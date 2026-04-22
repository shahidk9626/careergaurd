<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'role_id',
        'emp_code',
        'slug',
        'first_name',
        'last_name',
        'full_name',
        'father_name',
        'mother_name',
        'nominee_name',
        'email',
        'phone',
        'alternate_phone',
        'dob',
        'gender',
        'marital_status',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'department',
        'designation',
        'joining_date',
        'salary',
        'bank_name',
        'account_number',
        'ifsc_code',
        'pan_number',
        'aadhar_number',
        'status',
        'created_by',
    ];

    /**
     * Get the role associated with the staff.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the documents associated with the staff.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(StaffDocument::class);
    }
}
