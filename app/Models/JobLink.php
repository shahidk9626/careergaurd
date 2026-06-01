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

    public function getLocationAttribute()
    {
        $locations = ['Bengaluru', 'Mumbai', 'Delhi NCR', 'Pune', 'Hyderabad', 'Remote', 'Chennai', 'Noida'];
        return $locations[$this->id % count($locations)];
    }

    public function getExperienceAttribute()
    {
        $experiences = ['0-1 Years', '1-3 Years', '2-5 Years', '3-7 Years', '4-8 Years', '5-10 Years'];
        return $experiences[$this->id % count($experiences)];
    }

    public function getSalaryAttribute()
    {
        $salaries = [
            '₹3,50,000 - ₹6,00,000 P.A.',
            '₹6,00,000 - ₹9,50,000 P.A.',
            '₹10,00,000 - ₹15,00,000 P.A.',
            '₹15,00,000 - ₹22,00,000 P.A.',
            '₹22,00,000 - ₹35,00,000 P.A.'
        ];
        return $salaries[$this->id % count($salaries)];
    }

    public function getSkillsAttribute()
    {
        $skillsets = [
            ['PHP', 'Laravel', 'MySQL', 'Git'],
            ['React.js', 'JavaScript', 'TailwindCSS', 'REST APIs'],
            ['Vue.js', 'Nuxt.js', 'CSS3', 'JavaScript'],
            ['Python', 'Django', 'PostgreSQL', 'Docker'],
            ['AWS', 'Node.js', 'Express', 'MongoDB'],
            ['TypeScript', 'Angular', 'RxJS', 'SCSS'],
        ];
        return $skillsets[$this->id % count($skillsets)];
    }

    public function getPostedDateAttribute()
    {
        if ($this->created_at) {
            return $this->created_at->diffForHumans();
        }
        $daysAgo = ($this->id % 7) + 1;
        return $daysAgo === 1 ? '1 day ago' : "{$daysAgo} days ago";
    }

    public function getJobDetailsAttribute()
    {
        return [
            'location' => $this->location,
            'experience' => $this->experience,
            'salary' => $this->salary,
            'posted_date' => $this->posted_date,
            'skills' => $this->skills,
        ];
    }
}
