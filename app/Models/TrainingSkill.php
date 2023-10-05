<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSkill extends Model
{
    use HasFactory;
    public $table = 'training_skills';

    protected $fillable = [
        'name',
        'status',
    ];
}
