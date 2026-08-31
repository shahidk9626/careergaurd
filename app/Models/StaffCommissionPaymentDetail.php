<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class StaffCommissionPaymentDetail extends Model
{
    use HasFactory, Auditable;

    protected $table = 'staff_commission_payment_details';

    protected $fillable = [
        'payment_id',
        'purchased_plan_id',
        'customer_id',
        'plan_id',
        'commission_amount',
        'status',
        'description',
    ];

    protected $casts = [
        'commission_amount' => 'decimal:2',
    ];

    public function payment()
    {
        return $this->belongsTo(StaffCommissionPayment::class, 'payment_id');
    }

    public function purchasedPlan()
    {
        return $this->belongsTo(PurchasedPlan::class, 'purchased_plan_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
