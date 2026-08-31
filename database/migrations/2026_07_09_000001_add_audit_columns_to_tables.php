<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = [
            'users',
            'roles',
            'permissions',
            'modules',
            'role_permissions',
            'user_permissions',
            'staff_details',
            'customer_details',
            'staff_documents',
            'customer_documents',
            'plans',
            'plan_services',
            'resume_templates',
            'job_links',
            'interview_questions',
            'interview_pdf_resources',
            'claims',
            'purchased_plans',
            'transactions',
            'payment_orders',
            'payment_failures',
            'claimed_transactions',
            'staff_membership_referrals',
            'customer_update_requests',
            'customer_update_request_details',
            'callback_requests',
            'staff_commission_payments',
            'staff_commission_payment_details',
            'service_categories',
            'resume_template_categories',
            'job_link_categories',
            'interview_question_categories',
            'interview_pdf_resource_category'
        ];

        foreach ($tables as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'created_by')) {
                    $table->unsignedBigInteger('created_by')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'created_by_type')) {
                    $table->string('created_by_type')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'updated_by')) {
                    $table->unsignedBigInteger('updated_by')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'updated_by_type')) {
                    $table->string('updated_by_type')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'deleted_by')) {
                    $table->unsignedBigInteger('deleted_by')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'deleted_by_type')) {
                    $table->string('deleted_by_type')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Dropping columns if they exist
        $tables = [
            'users',
            'roles',
            'permissions',
            'modules',
            'role_permissions',
            'user_permissions',
            'staff_details',
            'customer_details',
            'staff_documents',
            'customer_documents',
            'plans',
            'plan_services',
            'resume_templates',
            'job_links',
            'interview_questions',
            'interview_pdf_resources',
            'claims',
            'purchased_plans',
            'transactions',
            'payment_orders',
            'payment_failures',
            'claimed_transactions',
            'staff_membership_referrals',
            'customer_update_requests',
            'customer_update_request_details',
            'callback_requests',
            'staff_commission_payments',
            'staff_commission_payment_details',
            'service_categories',
            'resume_template_categories',
            'job_link_categories',
            'interview_question_categories',
            'interview_pdf_resource_category'
        ];

        // Skip created_by for tables that originally had it to preserve schema integrity
        $preserveCreatedBy = ['roles', 'staff_details', 'staff_commission_payments'];

        foreach ($tables as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName, $preserveCreatedBy) {
                $cols = [];
                if (!in_array($tableName, $preserveCreatedBy) && Schema::hasColumn($tableName, 'created_by')) {
                    $cols[] = 'created_by';
                }
                if (Schema::hasColumn($tableName, 'created_by_type')) {
                    $cols[] = 'created_by_type';
                }
                if (Schema::hasColumn($tableName, 'updated_by')) {
                    $cols[] = 'updated_by';
                }
                if (Schema::hasColumn($tableName, 'updated_by_type')) {
                    $cols[] = 'updated_by_type';
                }
                if (Schema::hasColumn($tableName, 'deleted_by')) {
                    $cols[] = 'deleted_by';
                }
                if (Schema::hasColumn($tableName, 'deleted_by_type')) {
                    $cols[] = 'deleted_by_type';
                }

                if (!empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }
    }
};
