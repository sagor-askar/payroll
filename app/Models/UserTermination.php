<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTermination extends Model
{
    use HasFactory;
    public $table = 'user_terminations';
    protected $fillable = [
        'employee_id',
        'termination_reason',
        'notice_date',
        'terminatation_date',
        'details'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

}
