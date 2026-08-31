<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Plan extends Model
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'premium_amount',
        'commission_amount',
        'tenure_type',
        'tenure_value',
        'claim_duration_days',
        'compensation_amount',
        'status',
        'prematurity_available',
        'one_time_payment_applicable',
        'one_time_payment_amount',
        'discount_price',
    ];

    protected $casts = [
        'prematurity_available' => 'boolean',
        'one_time_payment_applicable' => 'boolean',
    ];

    public function planServices()
    {
        return $this->hasMany(PlanService::class);
    }
}
