<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\Auth\VerifyEmailController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return "All caches cleared successfully (cache, route, config, view).";
});

// Custom Manual Verification Route
Route::get('/customer/verify/{id}/{hash}', [VerifyEmailController::class, 'verifyCustom'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify.custom');

// Public Cashfree Webhook Route
Route::post('/customer/payment/webhook', [App\Http\Controllers\PlanController::class, 'webhook'])->name('customer.payment.webhook');

// Public Referral Payment Routes
Route::get('/customers/pay-referral/{order_id}', [App\Http\Controllers\StaffReferralController::class, 'payReferral'])->name('pay-referral');
Route::get('/customers/payment-success/{order_id}', [App\Http\Controllers\StaffReferralController::class, 'paymentSuccess'])->name('payment-success');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'customer.profile'])->name('dashboard');

Route::middleware(['auth', 'customer.profile'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Roles CRUD Routes
    Route::middleware('permission:roles.view')->get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
    Route::middleware('permission:roles.create')->post('/roles/store', [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
    Route::middleware('permission:roles.edit')->post('/roles/update/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
    Route::middleware('permission:roles.delete')->delete('/roles/delete/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');
    Route::middleware('permission:roles.delete')->post('/roles/bulk-delete', [App\Http\Controllers\RoleController::class, 'bulkDestroy'])->name('roles.bulk-destroy');
    Route::middleware('permission:roles.status')->post('/roles/status/{id}', [App\Http\Controllers\RoleController::class, 'toggleStatus'])->name('roles.status');
    Route::middleware('permission:roles.edit')->get('/roles/permissions/{id}', [App\Http\Controllers\RoleController::class, 'getPermissions'])->name('roles.permissions');

    // Role Permissions management
    Route::middleware('permission:roles.view')->get('/role-permissions', [App\Http\Controllers\RoleController::class, 'rolePermissionsIndex'])->name('role-permissions.index');
    Route::middleware('permission:roles.edit')->get('/role-permissions/{id}', [App\Http\Controllers\RoleController::class, 'manageRolePermissions'])->name('role-permissions.manage');

    // User Permissions management
    Route::middleware('permission:user-permissions.view')->get('/user-permissions', [App\Http\Controllers\StaffController::class, 'userPermissionsIndex'])->name('user-permissions.index');
    Route::middleware('permission:user-permissions.edit')->get('/user-permissions/{id}', [App\Http\Controllers\StaffController::class, 'manageUserPermissions'])->name('user-permissions.manage');
    Route::middleware('permission:user-permissions.edit')->post('/user-permissions/{id}', [App\Http\Controllers\StaffController::class, 'saveUserPermissions'])->name('user-permissions.save');

    Route::middleware('permission:staff.view')->group(function () {
        Route::get('/staff', [App\Http\Controllers\StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/{id}/view', [App\Http\Controllers\StaffController::class, 'show'])->name('staff.show');
    });
    Route::middleware('permission:staff.create')->group(function () {
        Route::get('/staff/create', [App\Http\Controllers\StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff/store', [App\Http\Controllers\StaffController::class, 'store'])->name('staff.store');
    });
    Route::middleware('permission:staff.edit')->group(function () {
        Route::get('/staff/edit/{slug}', [App\Http\Controllers\StaffController::class, 'edit'])->name('staff.edit');
        Route::post('/staff/update/{slug}', [App\Http\Controllers\StaffController::class, 'update'])->name('staff.update');
        Route::get('/staff/access/{slug}', [App\Http\Controllers\StaffController::class, 'access'])->name('staff.access');
        Route::post('/staff/access/{slug}', [App\Http\Controllers\StaffController::class, 'saveAccess'])->name('staff.save-access');
    });
    Route::middleware('permission:staff.delete')->group(function () {
        Route::delete('/staff/delete/{id}', [App\Http\Controllers\StaffController::class, 'destroy'])->name('staff.destroy');
        Route::post('/staff/bulk-delete', [App\Http\Controllers\StaffController::class, 'bulkDestroy'])->name('staff.bulk-destroy');
        Route::delete('/staff/delete-document/{id}', [App\Http\Controllers\StaffController::class, 'deleteDocument'])->name('staff.delete-document');
    });
    Route::middleware('permission:staff.status')->post('/staff/status/{id}', [App\Http\Controllers\StaffController::class, 'toggleStatus'])->name('staff.status');

    // Customer Onboarding (Force Complete / flow validation)
    Route::get('/customer/registration', [App\Http\Controllers\CustomerController::class, 'registration'])->name('customer.registration');
    Route::post('/customer/registration', [App\Http\Controllers\CustomerController::class, 'storeProfile'])->name('customer.store-profile');

    // Customer Dashboard & Other Protected Pages
    Route::middleware(['customer.profile', 'verified'])->group(function () {
        Route::get('/customer/dashboard', [App\Http\Controllers\CustomerController::class, 'dashboard'])->name('customer.dashboard');
        Route::get('/customer/services', [App\Http\Controllers\CustomerController::class, 'dashboard'])->name('customer.services'); // Placeholder
    });

    // Admin Customer Management
    Route::prefix('admin')->group(function () {
        Route::middleware('permission:customers.view')->group(function () {
            Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('admin.customers.index');
            Route::get('/customers/{id}/view', [App\Http\Controllers\CustomerController::class, 'show'])->name('admin.customers.show');
        });
        Route::middleware('permission:customers.create')->group(function () {
            Route::get('/customers/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('admin.customers.create');
            Route::post('/customers/store', [App\Http\Controllers\CustomerController::class, 'store'])->name('admin.customers.store');
        });
        Route::middleware('permission:customers.edit')->group(function () {
            Route::get('/customers/{id}/edit', [App\Http\Controllers\CustomerController::class, 'edit'])->name('admin.customers.edit');
            Route::match(['POST', 'PUT'], '/customers/{id}/update', [App\Http\Controllers\CustomerController::class, 'update'])->name('admin.customers.update');
            Route::post('/customers/{id}/verify', [App\Http\Controllers\CustomerController::class, 'verify'])->name('admin.customers.verify');
        });
        Route::middleware('permission:customers.delete')->delete('/customers/delete/{id}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('admin.customers.destroy');
        Route::middleware('permission:customers.delete')->post('/customers/bulk-delete', [App\Http\Controllers\CustomerController::class, 'bulkDestroy'])->name('admin.customers.bulk-destroy');

        Route::middleware('permission:customers.purchase_membership')->group(function () {
            Route::get('/customers/{id}/purchase-membership', [App\Http\Controllers\StaffReferralController::class, 'selectMembership'])->name('admin.customers.purchase-membership');
            Route::post('/customers/{id}/purchase-membership', [App\Http\Controllers\StaffReferralController::class, 'generatePaymentLink'])->name('admin.customers.generate-link');
        });

        // Categories
        Route::prefix('services/categories')->middleware('permission:service-categories.view')->group(function () {
            Route::get('/', [ServiceCategoryController::class, 'index'])->name('admin.services.categories.index');
            Route::post('/store', [ServiceCategoryController::class, 'store'])->middleware('permission:service-categories.create')->name('admin.services.categories.store');
            Route::get('/edit/{id}', [ServiceCategoryController::class, 'edit'])->middleware('permission:service-categories.edit')->name('admin.services.categories.edit');
            Route::post('/update/{id}', [ServiceCategoryController::class, 'update'])->middleware('permission:service-categories.edit')->name('admin.services.categories.update');
            Route::post('/status/{id}', [ServiceCategoryController::class, 'status'])->middleware('permission:service-categories.status')->name('admin.services.categories.status');
            Route::delete('/delete/{id}', [ServiceCategoryController::class, 'destroy'])->middleware('permission:service-categories.delete')->name('admin.services.categories.delete');
            Route::post('/bulk-delete', [ServiceCategoryController::class, 'bulkDestroy'])->middleware('permission:service-categories.delete')->name('admin.services.categories.bulk-delete');
        });

        // Resume Templates
        Route::prefix('services/resumes')->middleware('permission:resumes.view')->group(function () {
            Route::get('/', [App\Http\Controllers\ResumeTemplateController::class, 'index'])->name('admin.services.resumes.index');
            Route::post('/store', [App\Http\Controllers\ResumeTemplateController::class, 'store'])->middleware('permission:resumes.create')->name('admin.services.resumes.store');
            Route::get('/edit/{id}', [App\Http\Controllers\ResumeTemplateController::class, 'edit'])->middleware('permission:resumes.edit')->name('admin.services.resumes.edit');
            Route::post('/update/{id}', [App\Http\Controllers\ResumeTemplateController::class, 'update'])->middleware('permission:resumes.edit')->name('admin.services.resumes.update');
            Route::delete('/delete/{id}', [App\Http\Controllers\ResumeTemplateController::class, 'destroy'])->middleware('permission:resumes.delete')->name('admin.services.resumes.destroy');
            Route::post('/status/{id}', [App\Http\Controllers\ResumeTemplateController::class, 'toggleStatus'])->middleware('permission:resumes.status')->name('admin.services.resumes.status');
            Route::post('/bulk-delete', [App\Http\Controllers\ResumeTemplateController::class, 'bulkDestroy'])->middleware('permission:resumes.delete')->name('admin.services.resumes.bulk-delete');
        });

        // Job Links
        Route::prefix('services/job-links')->middleware('permission:job-links.view')->group(function () {
            Route::get('/', [App\Http\Controllers\JobLinkController::class, 'index'])->name('admin.services.job-links.index');
            Route::post('/store', [App\Http\Controllers\JobLinkController::class, 'store'])->middleware('permission:job-links.create')->name('admin.services.job-links.store');
            Route::get('/edit/{id}', [App\Http\Controllers\JobLinkController::class, 'edit'])->middleware('permission:job-links.edit')->name('admin.services.job-links.edit');
            Route::post('/update/{id}', [App\Http\Controllers\JobLinkController::class, 'update'])->middleware('permission:job-links.edit')->name('admin.services.job-links.update');
            Route::delete('/delete/{id}', [App\Http\Controllers\JobLinkController::class, 'destroy'])->middleware('permission:job-links.delete')->name('admin.services.job-links.destroy');
            Route::post('/status/{id}', [App\Http\Controllers\JobLinkController::class, 'toggleStatus'])->middleware('permission:job-links.status')->name('admin.services.job-links.status');
            Route::post('/export', [App\Http\Controllers\JobLinkController::class, 'export'])->middleware('permission:job-links.export')->name('admin.services.job-links.export');
            Route::post('/import', [App\Http\Controllers\JobLinkController::class, 'import'])->middleware('permission:job-links.import')->name('admin.services.job-links.import');
            Route::get('/download-template', [App\Http\Controllers\JobLinkController::class, 'downloadTemplate'])->middleware('permission:job-links.import')->name('admin.services.job-links.download-template');
            Route::post('/bulk-delete', [App\Http\Controllers\JobLinkController::class, 'bulkDestroy'])->middleware('permission:job-links.delete')->name('admin.services.job-links.bulk-delete');
        });

        // Interview Questions
Route::prefix('services/questions')->middleware('permission:questions.view')->group(function () {
    Route::get('/', [App\Http\Controllers\InterviewQuestionController::class, 'index'])->name('admin.services.questions.index');
    Route::post('/store', [App\Http\Controllers\InterviewQuestionController::class, 'store'])->middleware('permission:questions.create')->name('admin.services.questions.store');
    Route::get('/edit/{id}', [App\Http\Controllers\InterviewQuestionController::class, 'edit'])->middleware('permission:questions.edit')->name('admin.services.questions.edit');
    Route::post('/update/{id}', [App\Http\Controllers\InterviewQuestionController::class, 'update'])->middleware('permission:questions.edit')->name('admin.services.questions.update');
    Route::delete('/delete/{id}', [App\Http\Controllers\InterviewQuestionController::class, 'destroy'])->middleware('permission:questions.delete')->name('admin.services.questions.destroy');
    Route::post('/status/{id}', [App\Http\Controllers\InterviewQuestionController::class, 'toggleStatus'])->middleware('permission:questions.status')->name('admin.services.questions.status');
    Route::post('/bulk-delete', [App\Http\Controllers\InterviewQuestionController::class, 'bulkDestroy'])->middleware('permission:questions.delete')->name('admin.services.questions.bulk-delete');

    // PDF Resources
    Route::get('/pdf-resources', [App\Http\Controllers\InterviewPdfResourceController::class, 'index'])->name('admin.services.questions.pdf-resources.index');
    Route::post('/pdf-resources/store', [App\Http\Controllers\InterviewPdfResourceController::class, 'store'])->name('admin.services.questions.pdf-resources.store');
    Route::get('/pdf-resources/edit/{id}', [App\Http\Controllers\InterviewPdfResourceController::class, 'edit'])->name('admin.services.questions.pdf-resources.edit');
    Route::post('/pdf-resources/update/{id}', [App\Http\Controllers\InterviewPdfResourceController::class, 'update'])->name('admin.services.questions.pdf-resources.update');
    Route::delete('/pdf-resources/delete/{id}', [App\Http\Controllers\InterviewPdfResourceController::class, 'destroy'])->name('admin.services.questions.pdf-resources.destroy');
    Route::post('/pdf-resources/status/{id}', [App\Http\Controllers\InterviewPdfResourceController::class, 'toggleStatus'])->name('admin.services.questions.pdf-resources.status');
});

        

        // Plans
        Route::prefix('plans')->middleware('permission:plans.view')->group(function () {
            Route::get('/', [App\Http\Controllers\PlanController::class, 'index'])->name('admin.plans.index');
            Route::get('/create', [App\Http\Controllers\PlanController::class, 'create'])->middleware('permission:plans.create')->name('admin.plans.create');
            Route::post('/store', [App\Http\Controllers\PlanController::class, 'store'])->middleware('permission:plans.create')->name('admin.plans.store');
            Route::get('/edit/{id}', [App\Http\Controllers\PlanController::class, 'edit'])->middleware('permission:plans.edit')->name('admin.plans.edit');
            Route::post('/update/{id}', [App\Http\Controllers\PlanController::class, 'update'])->middleware('permission:plans.edit')->name('admin.plans.update');
            Route::delete('/delete/{id}', [App\Http\Controllers\PlanController::class, 'destroy'])->middleware('permission:plans.delete')->name('admin.plans.destroy');
            Route::post('/status/{id}', [App\Http\Controllers\PlanController::class, 'toggleStatus'])->middleware('permission:plans.status')->name('admin.plans.status');
            Route::get('/plan-preview', [App\Http\Controllers\PlanController::class, 'preview'])->middleware('permission:plans.preview')->name('admin.plans.preview');
            Route::post('/bulk-delete', [App\Http\Controllers\PlanController::class, 'bulkDestroy'])->middleware('permission:plans.delete')->name('admin.plans.bulk-delete');
        });

        // Purchased Plans & Claim Management
        Route::middleware('permission:purchased-plans.view')->group(function () {
            Route::get('/purchased-plans', [App\Http\Controllers\ClaimController::class, 'purchasedPlans'])->name('admin.purchased-plans');
            Route::get('/purchased-plan/{plan_unique_id}', [App\Http\Controllers\ClaimController::class, 'viewPlan'])->name('admin.purchased-plan.view');
            Route::get('/purchased-plan/{plan_unique_id}/pdf', [App\Http\Controllers\ClaimController::class, 'downloadPDF'])->name('admin.purchased-plan.pdf');
            Route::get('/claim-management', [App\Http\Controllers\ClaimController::class, 'claimManagement'])->name('admin.claim-management');
        });
        
        // Claim Requests
        Route::middleware('permission:claims.view')->group(function () {
            Route::get('/claim-requests', [App\Http\Controllers\ClaimController::class, 'adminClaimRequests'])->name('admin.claim.requests');
            Route::post('/claim-requests/update-status', [App\Http\Controllers\ClaimController::class, 'updateClaimStatus'])->middleware('permission:claims.approve')->name('admin.claim.update-status');
        });

        // Callback Requests
        Route::middleware('permission:request-callback.view')->group(function () {
            Route::get('/request-callback', [App\Http\Controllers\CallbackRequestController::class, 'adminIndex'])->name('admin.request-callback.index');
            Route::post('/request-callback/update-status', [App\Http\Controllers\CallbackRequestController::class, 'updateStatus'])->middleware('permission:request-callback.status')->name('admin.request-callback.update-status');
            Route::delete('/request-callback/delete/{id}', [App\Http\Controllers\CallbackRequestController::class, 'destroy'])->middleware('permission:request-callback.delete')->name('admin.request-callback.destroy');
            Route::post('/request-callback/bulk-delete', [App\Http\Controllers\CallbackRequestController::class, 'bulkDestroy'])->middleware('permission:request-callback.delete')->name('admin.request-callback.bulk-destroy');
            Route::get('/request-callback/export', [App\Http\Controllers\CallbackRequestController::class, 'export'])->middleware('permission:request-callback.export')->name('admin.request-callback.export');
        });

        // Profile Update Requests
        Route::middleware('permission:profile-update-requests.view')->group(function () {
            Route::get('/profile-update-requests', [App\Http\Controllers\ProfileUpdateRequestController::class, 'index'])->name('admin.profile-update-requests.index');
            Route::get('/profile-update-requests/{id}', [App\Http\Controllers\ProfileUpdateRequestController::class, 'show'])->name('admin.profile-update-requests.show');
        });
        Route::middleware('permission:profile-update-requests.approve')->post('/profile-update-requests/{id}/approve', [App\Http\Controllers\ProfileUpdateRequestController::class, 'approve'])->name('admin.profile-update-requests.approve');
        Route::middleware('permission:profile-update-requests.reject')->post('/profile-update-requests/{id}/reject', [App\Http\Controllers\ProfileUpdateRequestController::class, 'reject'])->name('admin.profile-update-requests.reject');

        // Staff Commission Management
        Route::middleware('permission:staff-commission.view')->group(function () {
            Route::get('/staff-commission', [App\Http\Controllers\StaffCommissionController::class, 'index'])->name('admin.staff-commission.index');
            Route::get('/staff-commission/search', [App\Http\Controllers\StaffCommissionController::class, 'search'])->name('admin.staff-commission.search');
            Route::get('/staff-commission/export-pdf', [App\Http\Controllers\StaffCommissionController::class, 'downloadInvoice'])->name('admin.staff-commission.export-pdf')->middleware('permission:staff-commission.export');
        });
        Route::middleware('permission:staff-commission.status')->group(function () {
            Route::post('/staff-commission/{id}/status', [App\Http\Controllers\StaffCommissionController::class, 'updateStatus'])->name('admin.staff-commission.status');
        });

        // Commission Management
        Route::middleware('permission:commission.view')->group(function () {
            Route::get('/commission', [App\Http\Controllers\CommissionController::class, 'index'])->name('admin.commission.index');
            Route::get('/commission/summary', [App\Http\Controllers\CommissionController::class, 'summary'])->name('admin.commission.summary');
            Route::get('/commission/export-pdf', [App\Http\Controllers\CommissionController::class, 'downloadInvoice'])->name('admin.commission.export-pdf')->middleware('permission:commission.export');
            Route::post('/commission/manage', [App\Http\Controllers\CommissionController::class, 'manageCommission'])->name('admin.commission.manage');
            Route::post('/commission/bulk-settle', [App\Http\Controllers\CommissionController::class, 'bulkSettle'])->name('admin.commission.bulk-settle');
            Route::get('/commission/payment-history', [App\Http\Controllers\CommissionController::class, 'paymentHistory'])->name('admin.commission.payment-history');
        });

        // Activity Logs Admin Views
        Route::middleware('permission:activity-logs.view')->prefix('activity-logs')->group(function () {
            Route::get('/', [App\Http\Controllers\ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
            Route::get('/{id}', [App\Http\Controllers\ActivityLogController::class, 'show'])->name('admin.activity-logs.show');
        });
    });

    // AJAX Entity History Endpoint
    Route::get('/activity-logs/entity-history', [App\Http\Controllers\ActivityLogController::class, 'entityHistory'])->name('admin.activity-logs.entity-history');

    // Customer-specific routes
    Route::middleware(['auth', 'is_customer'])->prefix('customer')->group(function () {
        Route::get('/plan-preview', [App\Http\Controllers\PlanController::class, 'preview'])->name('customer.plan-preview');
        Route::get('/plan/{slug}', [App\Http\Controllers\PlanController::class, 'show'])->name('customer.plan.show');
        Route::post('/plan/purchase', [App\Http\Controllers\PlanController::class, 'purchase'])->name('customer.plan.purchase');
        Route::get('/payment/callback', [App\Http\Controllers\PlanController::class, 'callback'])->name('customer.payment.callback');
        
        // Dynamic Customer Benefits Portals
        Route::get('/job-links', [App\Http\Controllers\CustomerBenefitController::class, 'jobLinks'])->name('customer.job-links');
        Route::get('/resume-templates', [App\Http\Controllers\CustomerBenefitController::class, 'resumeTemplates'])->name('customer.resume-templates');
        Route::get('/resume-templates/{id}/download', [App\Http\Controllers\CustomerBenefitController::class, 'downloadResumeTemplate'])->name('customer.resume-templates.download');
        Route::get('/interview-questions', [App\Http\Controllers\CustomerBenefitController::class, 'interviewQuestions'])->name('customer.interview-questions');
        Route::get('/interview-questions/category/{id}', [App\Http\Controllers\CustomerBenefitController::class, 'interviewQuestionsCategory'])->name('customer.interview-questions.category');
        Route::get('/interview-pdfs', [App\Http\Controllers\InterviewPdfResourceController::class, 'customerIndex'])->name('customer.interview-pdfs');
        // Profile check logic
        Route::get('/profile-redirect', function () {
            if (auth()->user()->profile_completed) {
                return redirect()->route('customer.profile');
            }
            return redirect()->route('customer.registration');
        })->name('customer.profile.check');

        // Customer Purchased Plans & Claim Management
        Route::get('/profile', [App\Http\Controllers\CustomerController::class, 'profile'])->name('customer.profile');
        Route::get('/profile/edit', [App\Http\Controllers\CustomerController::class, 'editProfile'])->name('customer.profile.edit');
        Route::post('/profile/update', [App\Http\Controllers\CustomerController::class, 'updateProfile'])->name('customer.profile.update');

        Route::get('/purchased-plans', [App\Http\Controllers\ClaimController::class, 'purchasedPlans'])->name('customer.purchased-plans');
        Route::get('/purchased-plan/{plan_unique_id}', [App\Http\Controllers\ClaimController::class, 'viewPlan'])->name('customer.purchased-plan.view');
        Route::get('/purchased-plan/{plan_unique_id}/pdf', [App\Http\Controllers\ClaimController::class, 'downloadPDF'])->name('customer.purchased-plan.pdf');
        Route::get('/claim-management', [App\Http\Controllers\ClaimController::class, 'claimManagement'])->name('customer.claim-management');
        Route::get('/claim/{plan_unique_id}', [App\Http\Controllers\ClaimController::class, 'showClaimForm'])->name('customer.claim.form');
        Route::post('/claim/submit', [App\Http\Controllers\ClaimController::class, 'submitClaim'])->name('customer.claim.submit');

        Route::post('/callback-request', [App\Http\Controllers\CallbackRequestController::class, 'store'])->name('customer.callback-request.store');
    });
});

require __DIR__ . '/auth.php';
