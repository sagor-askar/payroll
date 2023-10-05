<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalDeductionPenalty extends Model
{
    use HasFactory;
    public $table = 'additional_deduction_penalties';
    protected $fillable = [
        'employee_id',
        'additional_deduction_setup_id',
        'deduction',
        'deduction_date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function additional_deduction_setup()
    {
        return $this->belongsTo(AdditionalDeductionSetup::class, 'additional_deduction_setup_id');
    }
}
