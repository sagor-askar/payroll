<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplicationLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'loan_application_id',
        'loan_pay_date',
        'pay_amount',
        'due_amount'
    ];
}
