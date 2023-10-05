<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'bonus_date',
        'bonus_name',
        'bonus_percentage',
        'amount',
        'created_by',
        'created_at',
        'updated_at',

    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
