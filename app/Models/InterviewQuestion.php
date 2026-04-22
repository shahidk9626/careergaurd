<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterviewQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'category',
        'question_text',
        'answer_text',
        'status',
    ];

    public function categories()
    {
        return $this->belongsToMany(ServiceCategory::class, 'interview_question_categories');
    }
}
