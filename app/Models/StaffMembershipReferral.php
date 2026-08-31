<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class StaffMembershipReferral extends Model
{
    use HasFactory, Auditable;

    protected $table = 'staff_membership_referrals';

    protected $fillable = [
        'staff_id',
        'customer_id',
        'plan_id',
        'cashfree_order_id',
        'payment_link',
        'status',
        'payment_status',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'cashfree_order_id', 'cashfree_order_id');
    }
}
