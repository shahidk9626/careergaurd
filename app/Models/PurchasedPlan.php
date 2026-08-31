<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class PurchasedPlan extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'user_id',
        'plan_id',
        'plan_unique_id',
        'plan_name',
        'amount',
        'tenure_type',
        'tenure_value',
        'start_date',
        'end_date',
        'status',
        'referred_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class)->withTrashed();
    }

    public function claim()
    {
        return $this->hasOne(Claim::class, 'plan_unique_id', 'plan_unique_id');
    }

    public function referredByStaff()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }
}
