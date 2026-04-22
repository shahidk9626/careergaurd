<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'status'];

    public function resumeTemplates()
    {
        return $this->belongsToMany(ResumeTemplate::class, 'resume_template_categories');
    }

    public function jobLinks()
    {
        return $this->belongsToMany(JobLink::class, 'job_link_categories');
    }

    public function interviewQuestions()
    {
        return $this->belongsToMany(InterviewQuestion::class, 'interview_question_categories');
    }
}
