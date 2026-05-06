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
                    'verified' => $user->verification_status,
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
     * Admin Side: View Customer Profile
     */
    public function show($id)
    {
        $customer = User::with(['customerDetail', 'customerDocuments', 'referredBy.staffDetail'])->findOrFail($id);

        // Next/Previous Navigation
        $prev = User::where('role_id', 0)->where('id', '<', $id)->orderBy('id', 'desc')->first();
        $next = User::where('role_id', 0)->where('id', '>', $id)->orderBy('id', 'asc')->first();

        return view('admin.customers.show', compact('customer', 'prev', 'next'));
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
                'verification_status' => 'pending',
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
        $user = auth()->user();

        // CASE 1: Profile Not Completed (Handled by Middleware, but safe check)
        if (!$user->profile_completed) {
            return redirect()->route('customer.registration');
        }

        // CASE 3: Profile Verified AND Active -> Redirect to Profile
        if ($user->verification_status === 'verified' && $user->status === 'active') {
            return redirect()->route('customer.profile');
        }

        // CASE 2: Profile Completed but Pending Verification -> Show Dashboard with message
        return view('customer.dashboard');
    }

    /**
     * Customer Side: Profile View
     */
    public function profile()
    {
        $user = auth()->user()->load(['customerDetail', 'role']);
        return view('customer.profile', compact('user'));
    }

    /**
     * Customer Side: Edit Profile View
     */
    public function editProfile()
    {
        $user = auth()->user()->load('customerDetail');
        return view('customer.profile-edit', compact('user'));
    }

    /**
     * Customer Side: Update Profile
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $customerDetail = $user->customerDetail;

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'whatsapp_number' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $userData = [
                'name' => $request->name,
                'phone' => $request->phone,
                'whatsapp_number' => $request->whatsapp_number,
            ];

            // Handle Profile Image Upload
            if ($request->hasFile('profile_image')) {
                // Delete old image if exists
                if ($user->profile_image) {
                    Storage::disk('public')->delete($user->profile_image);
                }
                $path = $request->file('profile_image')->store('profile_images', 'public');
                $userData['profile_image'] = $path;
            }

            $user->update($userData);

            $customerDetail->update([
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
            ]);

            DB::commit();
            return redirect()->route('customer.profile')->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
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
    public function edit($id)
    {
        $customer = User::with(['customerDetail', 'customerDocuments', 'referredBy.staffDetail'])->findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Admin Side: Update Customer
     */
    public function update(Request $request, $id)
    {
        $user = User::with('customerDetail')->findOrFail($id);
        $customerDetail = $user->customerDetail;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'whatsapp_number' => 'required|string',
            'referral_code' => 'nullable|string|exists:staff_details,emp_code',
        ]);

        try {
            DB::beginTransaction();

            $referredById = $user->referred_by_staff_id;
            if ($request->has('referral_code')) {
                if ($request->referral_code) {
                    $staff = StaffDetail::where('emp_code', $request->referral_code)->first();
                    if ($staff) {
                        $referredById = $staff->user_id;
                    }
                } else {
                    $referredById = null;
                }
            }

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'whatsapp_number' => $request->whatsapp_number,
                'status' => $request->status ?? $user->status,
                'verification_status' => $request->verification_status ?? $user->verification_status,
                'referred_by_staff_id' => $referredById,
                'profile_completed' => $request->has('force_complete') ? 1 : $user->profile_completed,
            ];

            if ($request->has('phone')) {
                $userData['phone'] = $request->phone;
            }

            $user->update($userData);

            if ($customerDetail) {
                $customerDetail->update($request->all());
            } else {
                // BUG FIX: We must assign the created record back to the $customerDetail variable
                $slug = Str::slug($user->name . '-' . Str::random(5));
                $customerDetail = CustomerDetail::create(array_merge($request->all(), [
                    'user_id' => $user->id,
                    'slug' => $slug,
                ]));
            }

            // Handle New Documents
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $key => $file) {
                    if ($file) {
                        $docName = $request->document_names[$key] ?? $file->getClientOriginalName();
                        $path = $file->store('customer_docs', 'public');

                        CustomerDocument::create([
                            // BUG FIX: Use $customerDetail->id instead of $user->customerDetail->id
                            'customer_detail_id' => $customerDetail->id, 
                            'document_name' => $docName,
                            'file_path' => $path,
                            'file_original_name' => $file->getClientOriginalName(),
                            'file_type' => $file->getClientMimeType(),
                        ]);
                    }
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
    public function verify($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->verification_status = 'verified';
            $user->status = 'active';
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Customer verified successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Or toggle status
        return response()->json(['success' => 'Customer deleted successfully']);
    }
}
