<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_type',
        'question',
        'is_required',
    ];
}
