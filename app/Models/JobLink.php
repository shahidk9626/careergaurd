<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobLink extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'company_name',
        'job_url',
        'description',
        'status',
    ];

    public function categories()
    {
        return $this->belongsToMany(ServiceCategory::class, 'job_link_categories');
    }
}
