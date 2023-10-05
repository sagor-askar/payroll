<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'examination',
        'institute',
        'passing_year',
        'result',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
