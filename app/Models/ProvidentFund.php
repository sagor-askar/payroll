<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvidentFund extends Model
{
    use HasFactory;
    public $table = 'provident_funds';

    protected $fillable = [
        'employee_id',
        'pf_date',
        'pf_amount',
        'company_amount'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
