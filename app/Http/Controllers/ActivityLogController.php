<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activity logs.
     */
    public function index(Request $request)
    {
        // Check permission
        if (!hasPermission('activity-logs.view')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            $query = ActivityLog::query();
            
            // Search filter
            if ($request->filled('search.value')) {
                $search = $request->input('search.value');
                $query->where(function($q) use ($search) {
                    $q->where('performed_by_name', 'like', "%{$search}%")
                      ->orWhere('performed_by_role', 'like', "%{$search}%")
                      ->orWhere('action', 'like', "%{$search}%")
                      ->orWhere('module_name', 'like', "%{$search}%")
                      ->orWhere('reference_no', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // Module filter
            if ($request->filled('module')) {
                $query->where('module_slug', $request->input('module'));
            }

            // Action filter
            if ($request->filled('action_filter')) {
                $query->where('action', $request->input('action_filter'));
            }

            // Role filter
            if ($request->filled('role')) {
                $query->where('performed_by_role', $request->input('role'));
            }

            // Date Range filter
            if ($request->filled('date_range')) {
                $dates = explode(' - ', $request->input('date_range'));
                if (count($dates) === 2) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($dates[0])->startOfDay(),
                        Carbon::parse($dates[1])->endOfDay(),
                    ]);
                }
            }

            $totalData = ActivityLog::count();
            $totalFiltered = $query->count();
            
            $limit = $request->input('length', 10);
            $start = $request->input('start', 0);
            
            // Order
            $orderColumnIndex = $request->input('order.0.column', 0);
            $orderDir = $request->input('order.0.dir', 'desc');
            $columns = ['id', 'module_name', 'action', 'performed_by_name', 'performed_by_role', 'reference_no', 'created_at'];
            $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

            $logs = $query->orderBy($orderColumn, $orderDir)
                          ->offset($start)
                          ->limit($limit)
                          ->get();

            $data = $logs->map(function($log) {
                return [
                    'id' => $log->id,
                    'module_name' => $log->module_name,
                    'action' => $log->action,
                    'performed_by_name' => $log->performed_by_name,
                    'performed_by_role' => $log->performed_by_role,
                    'reference_no' => $log->reference_no ?? 'N/A',
                    'created_at' => $log->created_at->timezone('Asia/Kolkata')->format('Y-m-d H:i:s'),
                ];
            });

            return response()->json([
                "draw"            => intval($request->input('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $data   
            ]);
        }
        
        $modules = ActivityLog::select('module_name', 'module_slug')
            ->distinct()
            ->orderBy('module_name')
            ->get();
            
        $actions = ActivityLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->get();
            
        $roles = ActivityLog::select('performed_by_role')
            ->distinct()
            ->whereNotNull('performed_by_role')
            ->orderBy('performed_by_role')
            ->get();

        return view('admin.activity-logs.index', compact('modules', 'actions', 'roles'));
    }

    /**
     * Display the specified activity log detail.
     */
    public function show($id)
    {
        if (!hasPermission('activity-logs.detail')) {
            abort(403, 'Unauthorized action.');
        }

        $log = ActivityLog::findOrFail($id);
        return view('admin.activity-logs.show', compact('log'));
    }

    /**
     * SECURE AJAX API: Fetch the history timeline for a specific entity.
     */
    public function entityHistory(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $entityType = $request->input('entity_type');
        $entityId = $request->input('entity_id');

        if (!$entityType || !$entityId) {
            return response()->json(['error' => 'Invalid parameters'], 400);
        }

        // Access Control checks:
        // Customers can ONLY view their own Customer or PurchasedPlan logs.
        if ($user->role_id === 0) {
            if ($entityType === 'Customer' && $entityId != $user->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            if ($entityType === 'PurchasedPlan') {
                $plan = \App\Models\PurchasedPlan::find($entityId);
                if (!$plan || $plan->user_id != $user->id) {
                    return response()->json(['error' => 'Unauthorized'], 403);
                }
            }
            if (!in_array($entityType, ['Customer', 'PurchasedPlan'])) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        $logs = collect();

        if ($entityType === 'Customer') {
            $logs = ActivityLog::where(function($q) use ($entityId) {
                $q->where('record_id', $entityId)
                  ->where('module_slug', 'customers');
            })->orWhere(function($q) use ($entityId) {
                $q->where('performed_by', $entityId)
                  ->where('performed_by_type', 'Customer');
            })->orWhere(function($q) use ($entityId) {
                $purchasedPlanIds = \App\Models\PurchasedPlan::where('user_id', $entityId)->pluck('id');
                $q->whereIn('record_id', $purchasedPlanIds)
                  ->where('module_slug', 'purchased-memberships');
            })->orWhere(function($q) use ($entityId) {
                $claimIds = \App\Models\Claim::where('user_id', $entityId)->pluck('id');
                $q->whereIn('record_id', $claimIds)
                  ->where('module_slug', 'claims');
            })->latest('created_at')->get();
        } elseif ($entityType === 'Staff') {
            $logs = ActivityLog::where(function($q) use ($entityId) {
                $q->where('record_id', $entityId)
                  ->where('module_slug', 'staff');
            })->orWhere(function($q) use ($entityId) {
                $q->where('performed_by', $entityId)
                  ->where('performed_by_type', 'Staff');
            })->latest('created_at')->get();
        } elseif ($entityType === 'Plan') {
            $logs = ActivityLog::where('record_id', $entityId)
                ->where('module_slug', 'membership-plans')
                ->latest('created_at')->get();
        } elseif ($entityType === 'PurchasedPlan') {
            $purchasedPlan = \App\Models\PurchasedPlan::find($entityId);
            if ($purchasedPlan) {
                $logs = ActivityLog::where(function($q) use ($entityId) {
                    $q->where('record_id', $entityId)
                      ->where('module_slug', 'purchased-memberships');
                })->orWhere(function($q) use ($purchasedPlan) {
                    $q->where('reference_no', $purchasedPlan->plan_unique_id)
                      ->whereIn('action', ['PAYMENT_SUCCESS', 'PAYMENT_FAILED', 'PURCHASE_PLAN']);
                })->orWhere(function($q) use ($purchasedPlan) {
                    $claimIds = \App\Models\Claim::where('plan_unique_id', $purchasedPlan->plan_unique_id)->pluck('id');
                    $q->whereIn('record_id', $claimIds)
                      ->where('module_slug', 'claims');
                })->latest('created_at')->get();
            }
        } elseif ($entityType === 'Commission') {
            // Detailed commission auditing history for a staff user's commission transactions
            $logs = ActivityLog::where('module_slug', 'commission')
                ->where(function($q) use ($entityId) {
                    $q->where('record_id', $entityId)
                      ->orWhere('performed_by', $entityId);
                })
                ->latest('created_at')
                ->get();
        }

        $formattedLogs = $logs->map(function($log) {
            $icon = 'fa-info-circle';
            $color = 'from-gray-600 to-slate-300';
            
            switch($log->action) {
                case 'CREATE':
                case 'REGISTER':
                case 'ROLE_CREATED':
                case 'SERVICE_CREATED':
                case 'JOB_CREATED':
                case 'RESUME_CREATED':
                case 'INTERVIEW_CREATED':
                case 'CALLBACK_CREATED':
                case 'REFERRAL_CREATED':
                    $icon = 'fa-plus-circle';
                    $color = 'from-green-600 to-lime-400';
                    break;
                case 'UPDATE':
                case 'PROFILE_UPDATE':
                case 'ROLE_UPDATED':
                case 'SERVICE_UPDATED':
                case 'JOB_UPDATED':
                case 'RESUME_UPDATED':
                case 'INTERVIEW_UPDATED':
                    $icon = 'fa-edit';
                    $color = 'from-blue-600 to-cyan-400';
                    break;
                case 'DELETE':
                case 'ROLE_DELETED':
                case 'SERVICE_DELETED':
                case 'JOB_DELETED':
                case 'RESUME_DELETED':
                case 'INTERVIEW_DELETED':
                case 'CALLBACK_DELETED':
                    $icon = 'fa-trash-alt';
                    $color = 'from-red-600 to-rose-400';
                    break;
                case 'STATUS_CHANGE':
                    $icon = 'fa-toggle-on';
                    $color = 'from-orange-600 to-amber-400';
                    break;
                case 'CLAIM_APPROVED':
                case 'PROFILE_APPROVED':
                case 'PAYMENT_SUCCESS':
                case 'COMMISSION_PAID':
                    $icon = 'fa-check-circle';
                    $color = 'from-green-600 to-lime-400';
                    break;
                case 'CLAIM_REJECTED':
                case 'PROFILE_REJECTED':
                case 'PAYMENT_FAILED':
                    $icon = 'fa-times-circle';
                    $color = 'from-red-600 to-rose-400';
                    break;
                case 'LOGIN':
                    $icon = 'fa-sign-in-alt';
                    $color = 'from-purple-700 to-pink-500';
                    break;
                case 'LOGOUT':
                    $icon = 'fa-sign-out-alt';
                    $color = 'from-slate-650 to-slate-400';
                    break;
            }

            return [
                'id' => $log->id,
                'action' => $log->action,
                'icon' => $icon,
                'color' => $color,
                'performed_by_name' => $log->performed_by_name,
                'performed_by_role' => $log->performed_by_role,
                'description' => $log->description,
                'created_at' => $log->created_at->timezone('Asia/Kolkata')->format('d M Y, h:i A'),
            ];
        });

        return response()->json(['success' => true, 'logs' => $formattedLogs]);
    }
}
