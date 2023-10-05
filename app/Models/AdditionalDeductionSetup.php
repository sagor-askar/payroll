<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalDeductionSetup extends Model
{
    use HasFactory;
    public $table = 'additional_deduction_setups';
    protected $fillable = [
        'company_id',
        'sub_company_id',
        'deduction_name',
        'status',
        'created_by',
        'updated_by'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function sub_company()
    {
        return $this->belongsTo(SubCompany::class, 'sub_company_id');
    }
}
