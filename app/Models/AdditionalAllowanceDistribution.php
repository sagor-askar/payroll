<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalAllowanceDistribution extends Model
{
    use HasFactory;
    public $table = 'additional_allowance_distributions';
    protected $fillable = [
        'employee_id',
        'additional_allowance_setup_id',
        'allowance',
        'allowance_date',

    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function additional_allowance_setup()
    {
        return $this->belongsTo(AdditionalAllowanceSetup::class, 'additional_allowance_setup_id');
    }
}
