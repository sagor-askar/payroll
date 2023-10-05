<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;
    public $table = 'interviews';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'candidate_id',
        'job_id',
        'interview_date',
        'interview_time',
        'comment',
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
