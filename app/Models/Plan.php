<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'premium_amount',
        'tenure_type',
        'tenure_value',
        'claim_duration_days',
        'compensation_amount',
        'status',
    ];

    public function planServices()
    {
        return $this->hasMany(PlanService::class);
    }
}
