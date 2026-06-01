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

    public function getTechnologyAttribute()
    {
        $titleLower = strtolower($this->title);
        $textLower = strtolower($this->question_text);
        
        if (str_contains($titleLower, 'laravel') || str_contains($textLower, 'laravel')) return 'Laravel';
        if (str_contains($titleLower, 'react') || str_contains($textLower, 'react')) return 'React.js';
        if (str_contains($titleLower, 'vue') || str_contains($textLower, 'vue')) return 'Vue.js';
        if (str_contains($titleLower, 'php') || str_contains($textLower, 'php')) return 'PHP';
        if (str_contains($titleLower, 'python') || str_contains($textLower, 'python')) return 'Python';
        if (str_contains($titleLower, 'aws') || str_contains($textLower, 'aws')) return 'AWS';
        if (str_contains($titleLower, 'sql') || str_contains($textLower, 'sql') || str_contains($titleLower, 'mysql')) return 'SQL';
        if (str_contains($titleLower, 'docker') || str_contains($textLower, 'docker')) return 'Docker';
        if (str_contains($titleLower, 'node') || str_contains($textLower, 'node')) return 'Node.js';

        // Check if there is a category relationship
        if ($this->categories && $this->categories->first()) {
            return $this->categories->first()->name;
        }

        if ($this->category) {
            return $this->category;
        }

        $techs = ['Laravel', 'React.js', 'Python', 'Node.js', 'System Design', 'DevOps', 'SQL'];
        return $techs[$this->id % count($techs)];
    }

    public function getDifficultyAttribute()
    {
        $difficulties = ['Easy', 'Medium', 'Hard'];
        return $difficulties[$this->id % count($difficulties)];
    }

    public function getExplanationAttribute()
    {
        return "To answer this question effectively in an interview, focus on explaining both the theoretical concept and its practical implications. " .
               "Start with a concise, high-level summary of the core technology or pattern, then dive into specific use cases, advantages, and drawbacks. " .
               "Discuss performance trade-offs, scalability considerations, and clean code practices. If appropriate, detail a real-world scenario " .
               "where you successfully implemented or troubleshot this concept, highlighting the actions you took and the measurable results achieved. " .
               "Structuring your thoughts in this structured manner demonstrates deep technical understanding and professional engineering maturity.";
    }
}
