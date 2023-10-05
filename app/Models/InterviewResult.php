<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewResult extends Model
{
    use HasFactory;
    public $table = 'interview_results';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'candidate_id',
        'job_id',
        'interviewer',
        'viva_marks',
        'written_marks',
        'interview_date',
        'mcq_marks',
        'total_marks',
        'status',
        'details',
        'recommandation',
        'created_at',
        'updated_at',
    ];

    public function candidate()
    {
        return $this->belongsTo(JobApplications::class, 'candidate_id');
    }

    public function job()
    {
        return $this->belongsTo(JobsCreate::class, 'job_id');
    }

}
