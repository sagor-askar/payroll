<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryAllowance extends Model
{
    use HasFactory;

    public $table = 'salary_allowances';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'employee_id',
        'allowance_name',
        'percentage',
        'percentage_salary',
        'company_id',
        'sub_company_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function sub_company()
    {
        return $this->belongsTo(SubCompany::class, 'sub_company_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
