<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'profile_image', 'phone', 'whatsapp_number', 'password', 'role_id', 'referred_by_staff_id', 'profile_completed', 'verification_status', 'status', 'verification_sent_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function staffDetail()
    {
        return $this->hasOne(StaffDetail::class);
    }

    public function customerDetail()
    {
        return $this->hasOne(CustomerDetail::class);
    }

    public function staffDocuments()
    {
        return $this->hasMany(StaffDocument::class);
    }

    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by_staff_id');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by_staff_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions')->withPivot('allowed');
    }

    public function purchasedPlans()
    {
        return $this->hasMany(PurchasedPlan::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function customerDocuments()
    {
        return $this->hasManyThrough(CustomerDocument::class, CustomerDetail::class, 'user_id', 'customer_detail_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verification_sent_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        \Illuminate\Support\Facades\Mail::to($this->email)->send(new \App\Mail\ResetPasswordMail($this, $token));
    }

    public function profileUpdateRequests()
    {
        return $this->hasMany(CustomerUpdateRequest::class, 'customer_id');
    }

    /**
     * Get active unexpired purchased plans for the user.
     */
    public function getActivePurchasedPlans()
    {
        return $this->purchasedPlans()
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->get();
    }

    /**
     * Determine if customer has access to a specific benefit type based on active memberships.
     */
    public function hasBenefitAccess($serviceType)
    {
        $activePlanIds = $this->getActivePurchasedPlans()->pluck('plan_id');

        if ($activePlanIds->isEmpty()) {
            return false;
        }

        return \App\Models\PlanService::whereIn('plan_id', $activePlanIds)
            ->where('service_type', $serviceType)
            ->exists();
    }

    /**
     * Get allowed category IDs for a specific service type from active purchased plans.
     */
    public function getActivePurchasedPlanCategories($serviceType)
    {
        $activePlanIds = $this->getActivePurchasedPlans()->pluck('plan_id');

        if ($activePlanIds->isEmpty()) {
            return collect();
        }

        return \App\Models\PlanService::whereIn('plan_id', $activePlanIds)
            ->where('service_type', $serviceType)
            ->pluck('service_category_id');
    }
}
