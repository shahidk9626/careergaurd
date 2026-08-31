<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class ServiceCategory extends Model
{
    use HasFactory, Auditable;

    protected $fillable = ['name', 'slug', 'status', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(ServiceCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ServiceCategory::class, 'parent_id');
    }

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
