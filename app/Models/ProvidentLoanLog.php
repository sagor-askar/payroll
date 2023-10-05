<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvidentLoanLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'provident_loan_id',
        'pf_loan_pay_date',
        'pay_amount',
        'due_amount'
    ];
}
