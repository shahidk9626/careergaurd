<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\Auth\VerifyEmailController;

Route::get('/', function () {
    return view('welcome');
});

// Custom Manual Verification Route
Route::get('/customer/verify/{id}/{hash}', [VerifyEmailController::class, 'verifyCustom'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify.custom');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'customer.profile'])->name('dashboard');

Route::middleware(['auth', 'customer.profile'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Roles CRUD Routes
    Route::middleware('permission:roles.view')->get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
    Route::middleware('permission:roles.create')->post('/roles/store', [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
    Route::middleware('permission:roles.edit')->post('/roles/update/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
    Route::middleware('permission:roles.delete')->delete('/roles/delete/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');
    Route::middleware('permission:roles.status')->post('/roles/status/{id}', [App\Http\Controllers\RoleController::class, 'toggleStatus'])->name('roles.status');
    Route::middleware('permission:roles.edit')->get('/roles/permissions/{id}', [App\Http\Controllers\RoleController::class, 'getPermissions'])->name('roles.permissions');

    // Role Permissions management
    Route::middleware('permission:roles.view')->get('/role-permissions', [App\Http\Controllers\RoleController::class, 'rolePermissionsIndex'])->name('role-permissions.index');
    Route::middleware('permission:roles.edit')->get('/role-permissions/{id}', [App\Http\Controllers\RoleController::class, 'manageRolePermissions'])->name('role-permissions.manage');

    // User Permissions management
    Route::middleware('permission:staff.view')->get('/user-permissions', [App\Http\Controllers\StaffController::class, 'userPermissionsIndex'])->name('user-permissions.index');
    Route::middleware('permission:staff.edit')->get('/user-permissions/{id}', [App\Http\Controllers\StaffController::class, 'manageUserPermissions'])->name('user-permissions.manage');
    Route::middleware('permission:staff.edit')->post('/user-permissions/{id}', [App\Http\Controllers\StaffController::class, 'saveUserPermissions'])->name('user-permissions.save');

    // Staff Routes
    Route::middleware('permission:staff.view')->get('/staff', [App\Http\Controllers\StaffController::class, 'index'])->name('staff.index');
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
        Route::delete('/staff/delete-document/{id}', [App\Http\Controllers\StaffController::class, 'deleteDocument'])->name('staff.delete-document');
    });
    Route::middleware('permission:staff.status')->post('/staff/status/{id}', [App\Http\Controllers\StaffController::class, 'toggleStatus'])->name('staff.status');

    // Customer Registration (Forced Flow)
    Route::get('/customer/registration', [App\Http\Controllers\CustomerController::class, 'registration'])->name('customer.registration');
    Route::post('/customer/registration', [App\Http\Controllers\CustomerController::class, 'storeProfile'])->name('customer.store-profile');

    // Customer Dashboard & Other Protected Pages
    Route::middleware(['customer.profile', 'verified'])->group(function () {
        Route::get('/customer/dashboard', [App\Http\Controllers\CustomerController::class, 'dashboard'])->name('customer.dashboard');
        Route::get('/customer/profile', [App\Http\Controllers\CustomerController::class, 'profile'])->name('customer.profile'); // Placeholder
        Route::get('/customer/services', [App\Http\Controllers\CustomerController::class, 'dashboard'])->name('customer.services'); // Placeholder
    });

    // Admin Customer Management
    Route::prefix('admin')->group(function () {
        Route::middleware('permission:staff.view')->get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('admin.customers.index');
        Route::middleware('permission:staff.create')->group(function () {
            Route::get('/customers/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('admin.customers.create');
            Route::post('/customers/store', [App\Http\Controllers\CustomerController::class, 'store'])->name('admin.customers.store');
        });
        Route::middleware('permission:staff.edit')->group(function () {
            Route::get('/customers/edit/{slug}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('admin.customers.edit');
            Route::match(['POST', 'PUT'], '/customers/update/{slug}', [App\Http\Controllers\CustomerController::class, 'update'])->name('admin.customers.update');
        });
        Route::middleware('permission:staff.delete')->delete('/customers/delete/{id}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('admin.customers.destroy');

        // Categories
        Route::prefix('categories')->group(function () {
            Route::get('/', [ServiceCategoryController::class, 'index'])->name('admin.services.categories.index');
            Route::post('/store', [ServiceCategoryController::class, 'store'])->name('admin.services.categories.store');
            Route::get('/edit/{id}', [ServiceCategoryController::class, 'edit'])->name('admin.services.categories.edit');
            Route::post('/update/{id}', [ServiceCategoryController::class, 'update'])->name('admin.services.categories.update');
            Route::post('/status/{id}', [ServiceCategoryController::class, 'status'])->name('admin.services.categories.status');
            Route::delete('/delete/{id}', [ServiceCategoryController::class, 'destroy'])->name('admin.services.categories.delete');
        });

        // Resume Templates
        Route::get('/services/resumes', [App\Http\Controllers\ResumeTemplateController::class, 'index'])->name('admin.services.resumes.index');
        Route::post('/services/resumes/store', [App\Http\Controllers\ResumeTemplateController::class, 'store'])->name('admin.services.resumes.store');
        Route::get('/services/resumes/edit/{id}', [App\Http\Controllers\ResumeTemplateController::class, 'edit'])->name('admin.services.resumes.edit');
        Route::post('/services/resumes/update/{id}', [App\Http\Controllers\ResumeTemplateController::class, 'update'])->name('admin.services.resumes.update');
        Route::delete('/services/resumes/delete/{id}', [App\Http\Controllers\ResumeTemplateController::class, 'destroy'])->name('admin.services.resumes.destroy');
        Route::post('/services/resumes/status/{id}', [App\Http\Controllers\ResumeTemplateController::class, 'toggleStatus'])->name('admin.services.resumes.status');

        // Job Links
        Route::get('/services/job-links', [App\Http\Controllers\JobLinkController::class, 'index'])->name('admin.services.job-links.index');
        Route::post('/services/job-links/store', [App\Http\Controllers\JobLinkController::class, 'store'])->name('admin.services.job-links.store');
        Route::get('/services/job-links/edit/{id}', [App\Http\Controllers\JobLinkController::class, 'edit'])->name('admin.services.job-links.edit');
        Route::post('/services/job-links/update/{id}', [App\Http\Controllers\JobLinkController::class, 'update'])->name('admin.services.job-links.update');
        Route::delete('/services/job-links/delete/{id}', [App\Http\Controllers\JobLinkController::class, 'destroy'])->name('admin.services.job-links.destroy');
        Route::post('/services/job-links/status/{id}', [App\Http\Controllers\JobLinkController::class, 'toggleStatus'])->name('admin.services.job-links.status');

        // Interview Questions
        Route::get('/services/questions', [App\Http\Controllers\InterviewQuestionController::class, 'index'])->name('admin.services.questions.index');
        Route::post('/services/questions/store', [App\Http\Controllers\InterviewQuestionController::class, 'store'])->name('admin.services.questions.store');
        Route::get('/services/questions/edit/{id}', [App\Http\Controllers\InterviewQuestionController::class, 'edit'])->name('admin.services.questions.edit');
        Route::post('/services/questions/update/{id}', [App\Http\Controllers\InterviewQuestionController::class, 'update'])->name('admin.services.questions.update');
        Route::delete('/services/questions/delete/{id}', [App\Http\Controllers\InterviewQuestionController::class, 'destroy'])->name('admin.services.questions.destroy');
        Route::post('/services/questions/status/{id}', [App\Http\Controllers\InterviewQuestionController::class, 'toggleStatus'])->name('admin.services.questions.status');

        // Plans
        Route::get('/plans', [App\Http\Controllers\PlanController::class, 'index'])->name('admin.plans.index');
        Route::get('/plans/create', [App\Http\Controllers\PlanController::class, 'create'])->name('admin.plans.create');
        Route::post('/plans/store', [App\Http\Controllers\PlanController::class, 'store'])->name('admin.plans.store');
        Route::get('/plans/edit/{id}', [App\Http\Controllers\PlanController::class, 'edit'])->name('admin.plans.edit');
        Route::post('/plans/update/{id}', [App\Http\Controllers\PlanController::class, 'update'])->name('admin.plans.update');
        Route::delete('/plans/delete/{id}', [App\Http\Controllers\PlanController::class, 'destroy'])->name('admin.plans.destroy');
        Route::post('/plans/status/{id}', [App\Http\Controllers\PlanController::class, 'toggleStatus'])->name('admin.plans.status');
        Route::get('/plan-preview', [App\Http\Controllers\PlanController::class, 'preview'])->name('admin.plans.preview');

        // Purchased Plans & Claim Management
        Route::get('/purchased-plans', [App\Http\Controllers\ClaimController::class, 'purchasedPlans'])->name('admin.purchased-plans');
        Route::get('/purchased-plan/{plan_unique_id}', [App\Http\Controllers\ClaimController::class, 'viewPlan'])->name('admin.purchased-plan.view');
        Route::get('/claim-management', [App\Http\Controllers\ClaimController::class, 'claimManagement'])->name('admin.claim-management');
        Route::post('/claim-management/claim', [App\Http\Controllers\ClaimController::class, 'processClaim'])->name('admin.claim.process');
    });
    // Customer-specific routes
    Route::middleware(['auth', 'is_customer'])->prefix('customer')->group(function () {
        Route::get('/plan-preview', [App\Http\Controllers\PlanController::class, 'preview'])->name('customer.plan-preview');
        Route::get('/plan/{slug}', [App\Http\Controllers\PlanController::class, 'show'])->name('customer.plan.show');
        Route::post('/plan/purchase', [App\Http\Controllers\PlanController::class, 'purchase'])->name('customer.plan.purchase');
        
        // Profile check logic
        Route::get('/profile-redirect', function () {
            if (auth()->user()->profile_completed) {
                return redirect()->route('customer.profile');
            }
            return redirect()->route('customer.registration');
        })->name('customer.profile.check');

        // Customer Purchased Plans & Claim Management
        Route::get('/purchased-plans', [App\Http\Controllers\ClaimController::class, 'purchasedPlans'])->name('customer.purchased-plans');
        Route::get('/purchased-plan/{plan_unique_id}', [App\Http\Controllers\ClaimController::class, 'viewPlan'])->name('customer.purchased-plan.view');
        Route::get('/claim-management', [App\Http\Controllers\ClaimController::class, 'claimManagement'])->name('customer.claim-management');
        Route::post('/claim-management/claim', [App\Http\Controllers\ClaimController::class, 'processClaim'])->name('customer.claim.process');
    });
});

require __DIR__ . '/auth.php';
