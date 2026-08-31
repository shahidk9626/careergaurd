<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class ClaimedTransaction extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'claim_request_id',
        'user_id',
        'purchased_plan_id',
        'plan_id',
        'plan_unique_id',
        'claim_amount',
        'transaction_screenshot',
        'status',
        'remarks',
        'approved_by',
    ];

    public function claimRequest()
    {
        return $this->belongsTo(Claim::class, 'claim_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchasedPlan()
    {
        return $this->belongsTo(PurchasedPlan::class, 'purchased_plan_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
