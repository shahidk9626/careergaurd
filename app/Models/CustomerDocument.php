<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_detail_id',
        'document_name',
        'file_path',
        'file_original_name',
        'file_type',
    ];

    public function customerDetail()
    {
        return $this->belongsTo(CustomerDetail::class);
    }
}
