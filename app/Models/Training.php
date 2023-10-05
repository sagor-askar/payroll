<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;
    public $table = 'trainings';

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'employee_id',
        'trainer_id',
        'training_type_id',
        'training_skill_id',
        'cost',
        'start_date',
        'end_date',
        'description',
        'remarks',
        'performance',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }
    public function training_type()
    {
        return $this->belongsTo(TrainingType::class, 'training_type_id');
    }
    public function trainingSkill()
    {
        return $this->belongsTo(TrainingSkill::class, 'training_skill_id');
    }

}
