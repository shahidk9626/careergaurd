<?php

namespace App\Services;

use App\Helpers\AgentHelper;
use Illuminate\Support\Str;

class AuditService
{
    /**
     * List of sensitive fields that should be masked.
     */
    protected static $sensitiveFields = [
        'password',
        'password_hash',
        'remember_token',
        'otp',
        'secret',
        'cashfree_secret',
        'cashfree_secret_key',
        'api_key',
        'token',
        'session_id',
        'card_number',
        'cvv',
        'verification_code',
        'salary_slip',
        'termination_letter',
        'screenshot',
    ];

    /**
     * Map model classes to their audit metadata.
     */
    protected static $modelMapping = [
        \App\Models\User::class => [
            'name' => 'Users',
            'slug' => 'users',
        ],
        \App\Models\Role::class => [
            'name' => 'Roles',
            'slug' => 'roles',
        ],
        \App\Models\Permission::class => [
            'name' => 'Permissions',
            'slug' => 'permissions',
        ],
        \App\Models\Plan::class => [
            'name' => 'Membership Plans',
            'slug' => 'membership-plans',
        ],
        \App\Models\PurchasedPlan::class => [
            'name' => 'Purchased Memberships',
            'slug' => 'purchased-memberships',
        ],
        \App\Models\Transaction::class => [
            'name' => 'Transactions',
            'slug' => 'transactions',
        ],
        \App\Models\Claim::class => [
            'name' => 'Claims',
            'slug' => 'claims',
        ],
        \App\Models\CallbackRequest::class => [
            'name' => 'Callback Requests',
            'slug' => 'callback-requests',
        ],
        \App\Models\ResumeTemplate::class => [
            'name' => 'Resume Templates',
            'slug' => 'resume-templates',
        ],
        \App\Models\JobLink::class => [
            'name' => 'Job Links',
            'slug' => 'job-links',
        ],
        \App\Models\InterviewQuestion::class => [
            'name' => 'Interview Questions',
            'slug' => 'interview-questions',
        ],
        \App\Models\InterviewPdfResource::class => [
            'name' => 'Interview Questions',
            'slug' => 'interview-questions',
        ],
        \App\Models\StaffDetail::class => [
            'name' => 'Staff Profiles',
            'slug' => 'staff',
        ],
        \App\Models\CustomerDetail::class => [
            'name' => 'Customer Profiles',
            'slug' => 'customers',
        ],
        \App\Models\CustomerUpdateRequest::class => [
            'name' => 'Customer Profile Requests',
            'slug' => 'customer-profile-requests',
        ],
        \App\Models\StaffMembershipReferral::class => [
            'name' => 'Referrals',
            'slug' => 'referrals',
        ],
        \App\Models\StaffCommissionPayment::class => [
            'name' => 'Commission',
            'slug' => 'commission',
        ],
        \App\Models\StaffCommissionPaymentDetail::class => [
            'name' => 'Commission Details',
            'slug' => 'commission',
        ],
        \App\Models\ServiceCategory::class => [
            'name' => 'Services',
            'slug' => 'services',
        ],
        \App\Models\StaffDocument::class => [
            'name' => 'Staff Documents',
            'slug' => 'staff',
        ],
        \App\Models\CustomerDocument::class => [
            'name' => 'Customer Documents',
            'slug' => 'customers',
        ],
        \App\Models\ClaimedTransaction::class => [
            'name' => 'Claimed Transactions',
            'slug' => 'claims',
        ],
        \App\Models\PaymentOrder::class => [
            'name' => 'Cashfree Orders',
            'slug' => 'cashfree-payments',
        ],
        \App\Models\PaymentFailure::class => [
            'name' => 'Cashfree Failures',
            'slug' => 'cashfree-payments',
        ],
    ];

    /**
     * Write an audit log entry.
     */
    public static function log(
        string $moduleName,
        string $moduleSlug,
        string $action,
        $recordId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?array $changedFields = null,
        ?string $description = null,
        ?string $referenceNo = null,
        $user = null
    ): void {
        try {
            $userDetails = self::getUserDetails($user);
            $agentDetails = AgentHelper::getDetails();

            // Mask sensitive data
            if ($oldValues) {
                $oldValues = self::maskSensitiveData($oldValues);
            }
            if ($newValues) {
                $newValues = self::maskSensitiveData($newValues);
            }

            // Fallback for command line / artisan execution
            $ip = null;
            $url = 'CLI';
            $method = 'CLI';
            if (request()) {
                $ip = request()->ip();
                $url = request()->fullUrl();
                $method = request()->method();
            }

            \App\Models\ActivityLog::create([
                'module_name'        => $moduleName,
                'module_slug'        => $moduleSlug,
                'record_id'          => $recordId,
                'action'             => $action,
                'performed_by'       => $userDetails['id'],
                'performed_by_name'  => $userDetails['name'],
                'performed_by_role'  => $userDetails['role'],
                'performed_by_type'  => $userDetails['type'],
                'old_values'         => $oldValues,
                'new_values'         => $newValues,
                'changed_fields'     => $changedFields,
                'description'        => $description,
                'reference_no'       => $referenceNo,
                'ip_address'         => $ip,
                'browser'            => $agentDetails['browser'],
                'device'             => $agentDetails['device'],
                'operating_system'   => $agentDetails['os'],
                'url'                => $url,
                'http_method'        => $method,
                'request_id'         => app()->has('audit.request_id') ? app('audit.request_id') : (string) Str::uuid(),
                'created_at'         => now(),
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Activity Log Write Failed: " . $e->getMessage(), [
                'exception' => $e
            ]);
        }
    }

    /**
     * Resolve model metadata.
     */
    public static function getModelMetadata(string $class): ?array
    {
        return self::$modelMapping[$class] ?? null;
    }

    /**
     * Mask sensitive values recursively.
     */
    public static function maskSensitiveData(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = self::maskSensitiveData($value);
            } else {
                $keyLower = strtolower($key);
                $isSensitive = false;
                foreach (self::$sensitiveFields as $field) {
                    if (str_contains($keyLower, $field)) {
                        $isSensitive = true;
                        break;
                    }
                }
                if ($isSensitive) {
                    $data[$key] = '[MASKED]';
                }
            }
        }
        return $data;
    }

    /**
     * Get identity details of the user performing the action.
     */
    public static function getUserDetails($user = null): array
    {
        if (!$user) {
            $user = auth()->user();
        }

        if (!$user) {
            return [
                'id' => null,
                'name' => 'System',
                'role' => 'System',
                'type' => 'System',
            ];
        }

        // Customer type check: role_id = 0
        if ($user->role_id === 0) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'role' => 'Customer',
                'type' => 'Customer',
            ];
        }

        // Super Admin type check: id = 1 or matches admin role
        $isAdmin = ($user->id === 1) || 
                   ($user->role && in_array(strtolower($user->role->name), ['admin', 'super admin', 'superadmin'])) || 
                   ($user->role && $user->role->slug === 'admin');
                   
        if ($isAdmin) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role->name ?? 'Super Admin',
                'type' => 'Super Admin',
            ];
        }

        // Staff
        return [
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->role->name ?? 'Staff',
            'type' => 'Staff',
        ];
    }
}
