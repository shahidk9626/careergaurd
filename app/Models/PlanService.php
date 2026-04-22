<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanService extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'service_type',
        'service_id',
        'service_category_id',
        'quantity',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }
}
