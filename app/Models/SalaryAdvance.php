<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryAdvance extends Model
{
    use HasFactory;
    public $table = 'salary_advances';
    protected $fillable = [
        'employee_id',
        'amount',
        'sd_date',
        'company_id',
        'sub_company_id',
        'company_id',
        'created_by',
        'reason',
        'paid_status',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function subcompany()
    {
        return $this->belongsTo(SubCompany::class, 'sub_company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


}
