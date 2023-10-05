<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionHistory extends Model
{
    use HasFactory;

    public $table = 'promotion_histories';

    protected $fillable = [
        'employee_id',
        'department_id',
        'designation_id',
        'grade_id',
        'previous_amount',
        'promotion_amount',
        'previous_date',
        'promotion_date',
        'created_by'
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

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function promoted_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
