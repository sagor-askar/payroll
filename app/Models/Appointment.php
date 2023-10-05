<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'interview_result_id',
        'appointment_checklist_id',
        'status',
        'confirm_appointment_checklist_id',
        'created_at',
        'updated_at'
    ];

    public function appointmentChecklist()
    {
        return $this->belongsTo(AppointmentChecklist::class);
    }

    public function interview_result_candidate()
    {
        return $this->belongsTo(InterviewResult::class, 'interview_result_id');
    }
}
