<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerUpdateRequestDetail extends Model
{
    use HasFactory;

    protected $table = 'customer_update_request_details';

    protected $fillable = [
        'request_id',
        'field_name',
        'old_value',
        'new_value',
    ];

    public $timestamps = false;

    public function request()
    {
        return $this->belongsTo(CustomerUpdateRequest::class, 'request_id');
    }
}
