<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Transaction extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'user_id',
        'plan_id',
        'plan_unique_id',
        'amount',
        'payment_status',
        'payment_method',
        'transaction_reference',
        'cashfree_order_id',
        'cashfree_payment_id',
        'gateway_response',
    ];

    protected $casts = [
        'gateway_response' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
