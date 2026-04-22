<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'father_name',
        'mother_name',
        'dob',
        'gender',
        'marital_status',
        'alternate_number',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'pan_number',
        'aadhar_number',
        'occupation',
        'annual_income',
        'bank_name',
        'account_number',
        'ifsc_code',
        'branch',
        'slug',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(CustomerDocument::class);
    }
}
