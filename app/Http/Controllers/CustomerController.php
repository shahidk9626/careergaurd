<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\CustomerDetail;
use App\Models\CustomerDocument;
use App\Models\Role;
use App\Models\StaffDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Admin Side: Customer Listing
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with(['role', 'customerDetail', 'referredBy.staffDetail'])
                ->where('role_id', 0)->get();

            $data = $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'whatsapp' => $user->whatsapp_number,
                    'referral' => $user->referredBy ? ($user->referredBy->name . ' (' . ($user->referredBy->staffDetail->emp_code ?? 'N/A') . ')') : 'None',
                    'verified' => $user->email_verified_at ? 'Yes' : 'No',
                    'profile_complete' => $user->profile_completed ? 'Yes' : 'No',
                    'status' => $user->status,
                    'slug' => $user->customerDetail->slug ?? '',
                ];
            });
            return response()->json(['data' => $data]);
        }
        return view('admin.customers.index');
    }

    /**
     * Customer Side: Registration Wizard View
     */
    public function registration()
    {
        $user = auth()->user();
        if ($user->profile_completed) {
            return redirect()->route('customer.dashboard');
        }
        return view('customer.registration');
    }

    /**
     * Customer Side: Store Onboarding Profile
     */
    public function storeProfile(Request $request)
    {
        $user = auth()->user();

        try {
            DB::beginTransaction();

            // Generate Slug
            $slug = Str::slug($user->name . '-' . Str::random(5));

            // 1. Create Customer Details
            $customerDetail = CustomerDetail::create(array_merge($request->all(), [
                'user_id' => $user->id,
                'slug' => $slug,
            ]));

            // 2. Handle Documents
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $key => $file) {
                    $docName = $request->document_names[$key] ?? $file->getClientOriginalName();
                    $path = $file->store('customer_docs', 'public');

                    CustomerDocument::create([
                        'customer_detail_id' => $customerDetail->id,
                        'document_name' => $docName,
                        'file_path' => $path,
                        'file_original_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getClientMimeType(),
                    ]);
                }
            }

            // 3. Update User Status
            $user->update([
                'profile_completed' => 1,
                'status' => 'active',
            ]);

            DB::commit();
            return response()->json(['success' => 'Profile completed successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Customer Side: Dashboard
     */
    public function dashboard()
    {
        return view('customer.dashboard');
    }

    /**
     * Admin Side: Create View
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Admin Side: Store Manual Customer
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string',
            'whatsapp_number' => 'required|string',
            'referral_code' => 'nullable|string|exists:staff_details,emp_code',
        ]);

        try {
            DB::beginTransaction();

            $customerRole = Role::where('name', 'customer')->first();

            $referredById = null;
            if ($request->referral_code) {
                $staff = StaffDetail::where('emp_code', $request->referral_code)->first();
                if ($staff)
                    $referredById = $staff->user_id;
            }

            // Create User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'whatsapp_number' => $request->whatsapp_number,
                'password' => Hash::make(Str::random(10)),
                'role_id' => 0,
                'referred_by_staff_id' => $referredById,
                'status' => 'pending',
                'profile_completed' => 0,
            ]);

            // Create Initial Details if any provided in step form
            $slug = Str::slug($user->name . '-' . Str::random(5));
            $customerDetail = CustomerDetail::create(array_merge($request->all(), [
                'user_id' => $user->id,
                'slug' => $slug,
            ]));

            // Handle Documents
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $key => $file) {
                    $docName = $request->document_names[$key] ?? $file->getClientOriginalName();
                    $path = $file->store('customer_docs', 'public');

                    CustomerDocument::create([
                        'customer_detail_id' => $customerDetail->id,
                        'document_name' => $docName,
                        'file_path' => $path,
                        'file_original_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getClientMimeType(),
                    ]);
                }
            }

            // If created by admin, maybe auto-verify or keep pending
            // User requested same form logic, so we keep profile_completed 0 unless filled.
            if ($request->has('force_complete')) {
                $user->update(['profile_completed' => 1, 'status' => 'active']);
            }

            DB::commit();
            return response()->json(['success' => 'Customer created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Admin Side: Edit View
     */
    public function edit($slug)
    {
        $customerDetail = CustomerDetail::with(['user', 'documents'])->where('slug', $slug)->firstOrFail();
        return view('admin.customers.edit', compact('customerDetail'));
    }

    /**
     * Admin Side: Update Customer
     */
    public function update(Request $request, $slug)
    {
        $customerDetail = CustomerDetail::where('slug', $slug)->firstOrFail();
        $user = $customerDetail->user;

        try {
            DB::beginTransaction();

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'whatsapp_number' => $request->whatsapp_number,
                'status' => $request->status ?? 'pending',
            ]);

            $customerDetail->update($request->all());

            // Handle New Documents
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $key => $file) {
                    $docName = $request->document_names[$key] ?? $file->getClientOriginalName();
                    $path = $file->store('customer_docs', 'public');

                    CustomerDocument::create([
                        'customer_detail_id' => $customerDetail->id,
                        'document_name' => $docName,
                        'file_path' => $path,
                        'file_original_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getClientMimeType(),
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => 'Customer updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Admin Side: Destroy Customer
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Or toggle status
        return response()->json(['success' => 'Customer deleted successfully']);
    }
}
