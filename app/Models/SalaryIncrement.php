<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryIncrement extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'increment_date',
        'salary',
        'increment_percentage',
        'increment_amount',
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
