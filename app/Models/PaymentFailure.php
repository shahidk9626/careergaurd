<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class PaymentFailure extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'user_id',
        'plan_id',
        'order_id',
        'error_message',
        'gateway_response',
        'status',
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
