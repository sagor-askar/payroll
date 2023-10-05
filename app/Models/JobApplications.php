<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplications extends Model
{
    use HasFactory;
    public $table = 'job_applications';
    protected $fillable = [
        'job_id',
        'name',
        'email',
        'gender',
        'phone',
        'apply_date',
        'dob',
        'resume',
        'image',
        'cover_letter',
        'status',
    ];

    public function job()
    {
        return $this->belongsTo(JobsCreate::class, 'job_id');
    }
}
