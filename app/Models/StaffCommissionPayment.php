<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class StaffCommissionPayment extends Model
{
    use HasFactory, Auditable;

    protected $table = 'staff_commission_payments';

    protected $fillable = [
        'staff_id',
        'batch_reference',
        'total_policies',
        'total_commission_amount',
        'payment_proof',
        'description',
        'payment_date',
        'created_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'total_commission_amount' => 'decimal:2',
    ];

    public function details()
    {
        return $this->hasMany(StaffCommissionPaymentDetail::class, 'payment_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
