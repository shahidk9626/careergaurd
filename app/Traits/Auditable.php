<?php

namespace App\Traits;

use App\Services\AuditService;
use Illuminate\Support\Str;

trait Auditable
{
    /**
     * Boot the trait and register Eloquent event listeners.
     */
    public static function bootAuditable()
    {
        static::creating(function ($model) {
            $user = auth()->user();
            $userDetails = AuditService::getUserDetails($user);
            
            $schema = $model->getConnection()->getSchemaBuilder();
            if ($schema->hasColumn($model->getTable(), 'created_by')) {
                $model->created_by = $userDetails['id'];
                $model->created_by_type = $userDetails['type'];
            }
        });

        static::updating(function ($model) {
            $user = auth()->user();
            $userDetails = AuditService::getUserDetails($user);

            $schema = $model->getConnection()->getSchemaBuilder();
            if ($schema->hasColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = $userDetails['id'];
                $model->updated_by_type = $userDetails['type'];
            }
        });

        static::deleting(function ($model) {
            $user = auth()->user();
            $userDetails = AuditService::getUserDetails($user);

            $schema = $model->getConnection()->getSchemaBuilder();
            if ($schema->hasColumn($model->getTable(), 'deleted_by')) {
                $model->deleted_by = $userDetails['id'];
                $model->deleted_by_type = $userDetails['type'];
            }
            
            // Check if it is soft deleting or hard deleting
            if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(static::class))) {
                $model->saveQuietly();
            }
        });

        // Logging events
        static::created(function ($model) {
            self::logActivity($model, 'CREATE');
        });

        static::updated(function ($model) {
            $action = 'UPDATE';
            if ($model->wasChanged('status')) {
                $action = 'STATUS_CHANGE';
            }
            self::logActivity($model, $action);
        });

        static::deleted(function ($model) {
            self::logActivity($model, 'DELETE');
        });

        static::registerModelEvent('restored', function ($model) {
            self::logActivity($model, 'RESTORE');
        });
    }

    /**
     * Map model attributes and save to logs table.
     */
    protected static function logActivity($model, string $action)
    {
        try {
            // Check if activity_logs table exists to avoid migration crashes
            if (!\Illuminate\Support\Facades\Schema::hasTable('activity_logs')) {
                return;
            }

            $metadata = AuditService::getModelMetadata(get_class($model));
            if (!$metadata) {
                return;
            }

            $oldValues = null;
            $newValues = null;
            $changedFields = null;
            $description = null;
            $referenceNo = null;

            // Fetch primary reference number if available
            if (isset($model->plan_unique_id) && $model->plan_unique_id) {
                $referenceNo = $model->plan_unique_id;
            } elseif (isset($model->emp_code) && $model->emp_code) {
                $referenceNo = $model->emp_code;
            } elseif (isset($model->cashfree_order_id) && $model->cashfree_order_id) {
                $referenceNo = $model->cashfree_order_id;
            } elseif (isset($model->email) && $model->email) {
                $referenceNo = $model->email;
            } elseif (isset($model->id)) {
                $referenceNo = (string)$model->id;
            }

            if ($action === 'CREATE') {
                $newValues = $model->getAttributes();
                $description = "Created " . Str::singular($metadata['name']) . " record.";
            } elseif ($action === 'DELETE') {
                $oldValues = $model->getAttributes();
                $description = "Deleted " . Str::singular($metadata['name']) . " record.";
            } elseif ($action === 'RESTORE') {
                $newValues = $model->getAttributes();
                $description = "Restored " . Str::singular($metadata['name']) . " record.";
            } else {
                // UPDATE or STATUS_CHANGE
                $changes = $model->getChanges();
                
                // Exclude audit timestamps & users from triggering an update log
                $excludeFields = ['updated_at', 'updated_by', 'updated_by_type'];
                foreach ($excludeFields as $field) {
                    if (isset($changes[$field])) {
                        unset($changes[$field]);
                    }
                }
                
                $changedFields = array_keys($changes);

                if (empty($changedFields)) {
                    return; // No actual business fields changed, skip logging
                }

                $oldValues = [];
                $newValues = [];
                foreach ($changedFields as $field) {
                    $oldValues[$field] = $model->getOriginal($field);
                    $newValues[$field] = $model->getAttribute($field);
                }

                if ($action === 'STATUS_CHANGE') {
                    $oldStatus = $oldValues['status'] ?? 'N/A';
                    $newStatus = $newValues['status'] ?? 'N/A';
                    $description = "Status changed from '{$oldStatus}' to '{$newStatus}'.";
                } else {
                    $description = "Updated fields: " . implode(', ', $changedFields);
                }
            }

            // Map custom action based on model if applicable
            $customAction = self::resolveCustomAction($model, $action);

            AuditService::log(
                $metadata['name'],
                $metadata['slug'],
                $customAction,
                $model->id,
                $oldValues,
                $newValues,
                $changedFields,
                $description,
                $referenceNo
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Eloquent Auditing failed: " . $e->getMessage());
        }
    }

    /**
     * Resolve specific audit action names.
     */
    protected static function resolveCustomAction($model, string $defaultAction): string
    {
        $class = get_class($model);

        if ($defaultAction === 'CREATE') {
            if ($class === \App\Models\Role::class) return 'ROLE_CREATED';
            if ($class === \App\Models\User::class && $model->role_id === 0) return 'REGISTER';
            if ($class === \App\Models\Claim::class) return 'CLAIM_CREATED';
            if ($class === \App\Models\CallbackRequest::class) return 'CALLBACK_CREATED';
            if ($class === \App\Models\JobLink::class) return 'JOB_CREATED';
            if ($class === \App\Models\ResumeTemplate::class) return 'RESUME_CREATED';
            if ($class === \App\Models\InterviewQuestion::class || $class === \App\Models\InterviewPdfResource::class) return 'INTERVIEW_CREATED';
            if ($class === \App\Models\StaffMembershipReferral::class) return 'REFERRAL_CREATED';
            if ($class === \App\Models\ServiceCategory::class || $class === \App\Models\Plan::class) return 'SERVICE_CREATED';
            if ($class === \App\Models\PurchasedPlan::class) return 'PURCHASE_PLAN';
        }

        if ($defaultAction === 'UPDATE') {
            if ($class === \App\Models\Role::class) return 'ROLE_UPDATED';
            if ($class === \App\Models\JobLink::class) return 'JOB_UPDATED';
            if ($class === \App\Models\ResumeTemplate::class) return 'RESUME_UPDATED';
            if ($class === \App\Models\InterviewQuestion::class || $class === \App\Models\InterviewPdfResource::class) return 'INTERVIEW_UPDATED';
            if ($class === \App\Models\ServiceCategory::class || $class === \App\Models\Plan::class) return 'SERVICE_UPDATED';
            if ($class === \App\Models\UserPermission::class || $class === \App\Models\RolePermission::class) return 'PERMISSION_UPDATED';
            if ($class === \App\Models\User::class && $model->role_id === 0) return 'PROFILE_UPDATE';
        }

        if ($defaultAction === 'DELETE') {
            if ($class === \App\Models\Role::class) return 'ROLE_DELETED';
            if ($class === \App\Models\CallbackRequest::class) return 'CALLBACK_DELETED';
            if ($class === \App\Models\JobLink::class) return 'JOB_DELETED';
            if ($class === \App\Models\ResumeTemplate::class) return 'RESUME_DELETED';
            if ($class === \App\Models\InterviewQuestion::class || $class === \App\Models\InterviewPdfResource::class) return 'INTERVIEW_DELETED';
            if ($class === \App\Models\ServiceCategory::class || $class === \App\Models\Plan::class) return 'SERVICE_DELETED';
        }

        // Custom status audits
        if ($class === \App\Models\Claim::class && $model->wasChanged('status')) {
            if ($model->status === 'approved') return 'CLAIM_APPROVED';
            if ($model->status === 'rejected') return 'CLAIM_REJECTED';
            if ($model->status === 'paid') return 'CLAIM_PAID';
        }

        if ($class === \App\Models\CustomerUpdateRequest::class && $model->wasChanged('status')) {
            if ($model->status === 'approved') return 'PROFILE_APPROVED';
            if ($model->status === 'rejected') return 'PROFILE_REJECTED';
        }

        if ($class === \App\Models\Transaction::class && $model->wasChanged('payment_status')) {
            if ($model->payment_status === 'success' || $model->payment_status === 'paid') return 'PAYMENT_SUCCESS';
            if ($model->payment_status === 'failed' || $model->payment_status === 'failure') return 'PAYMENT_FAILED';
        }

        if ($class === \App\Models\StaffCommissionPaymentDetail::class && $model->wasChanged('status')) {
            if ($model->status === 'Paid') return 'COMMISSION_PAID';
        }

        return $defaultAction;
    }
}
