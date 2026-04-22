<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResumeTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'file_path',
        'status',
    ];

    public function categories()
    {
        return $this->belongsToMany(ServiceCategory::class, 'resume_template_categories');
    }
}
