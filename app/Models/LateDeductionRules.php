<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LateDeductionRules extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'sub_company_id',
        'late_days',
        'deduction_days',
        'salary_allowance_id',
        'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function sub_company()
    {
        return $this->belongsTo(SubCompany::class, 'sub_company_id');
    }

    public function salary_allowance()
    {
        return $this->belongsTo(SalaryAllowance::class, 'salary_allowance_id');
    }
}
