<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewPdfResource extends Model
{
    protected $fillable = ['title', 'description', 'file_path', 'status'];

    public function categories()
    {
        return $this->belongsToMany(ServiceCategory::class, 'interview_pdf_resource_category', 'pdf_resource_id', 'category_id');
    }
}