<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'plan_unique_id',
        'termination_letter',
        'salary_slips',
        'other_documents',
        'remarks',
        'status',
    ];

    protected $casts = [
        'salary_slips' => 'array',
        'other_documents' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function purchasedPlan()
    {
        return $this->belongsTo(PurchasedPlan::class, 'plan_unique_id', 'plan_unique_id');
    }
}
