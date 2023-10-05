<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobsCreate extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'department_id',
        'job_type',
        'no_of_positions',
        'start_date',
        'end_date',
        'skills',
        'office_time',
        'salary_range',
        'job_description',
        'job_requirement',
        'location',
        'need_to_ask',
        'need_to_show_option',
        'custom_question',
        'circulate_status',
        'approve_status',
        'created_by',
        'approved_by',
        'circulated_by',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
