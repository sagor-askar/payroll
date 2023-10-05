<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;
    public $table = 'overtimes';

    protected $fillable = [
        'employee_id',
        'ot_date',
        'ot_time',
        'working_hour',
        'hour_rate',
        'ot_salary',
        'reason',
        'created_by'
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
