<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'sub_company_id',
        'type',
        'name',
        'created_by_id',
        'start_time',
        'end_time',
        'loan_percentage',
        'period',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
