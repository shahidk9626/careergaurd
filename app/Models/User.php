<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'phone', 'whatsapp_number', 'password', 'role_id', 'referred_by_staff_id', 'profile_completed', 'status'])]
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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
