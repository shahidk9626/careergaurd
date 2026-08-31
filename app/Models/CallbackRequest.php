<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class CallbackRequest extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'user_id',
        'purchased_plan_id',
        'claim_id',
        'flag',
        'concern',
        'status',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchasedPlan()
    {
        return $this->belongsTo(PurchasedPlan::class, 'purchased_plan_id');
    }

    public function claim()
    {
        return $this->belongsTo(Claim::class, 'claim_id');
    }
}
