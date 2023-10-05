<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;

    public $table = 'requisitions';

    protected $fillable = [
        'employee_id',
        'department_id',
        'start_date',
        'end_date',
        'reason',
        'status',
        'approved_by',
        'created_by',
        'updated_at',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function approved()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
