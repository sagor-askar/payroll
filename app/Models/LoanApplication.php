<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;

    public $table = 'loan_applications';

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'employee_id',
        'permitted_id',
        'loan_details',
        'amount',
        'installment_amount',
        'installment_period',
        'apply_date',
        'approved_date',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'paid_amount',
        'due_amount',
        'adjustment_date',
        'paid_status',
        'active_status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function permitted_employee()
    {
        return $this->belongsTo(User::class, 'permitted_id');
    }

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
