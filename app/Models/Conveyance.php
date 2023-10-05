<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conveyance extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'department_id',
        'designation_id',
        'approved_by',
        'conveyance_date',
        'status'
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function approved()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

}
