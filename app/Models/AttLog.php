<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttLog extends Model
{
    use HasFactory;
    public $table = 'att_logs';

    protected $dates = [
        'authDate'
    ];
    protected $fillable = [
        'employee_id',
        'authDateTime',
        'authDate',
        'authTime',
        'direction',
        'deviceName',
        'deviceSN',
        'personName',
        'cardNo',
        'latitude',
        'longitude',
        'location',
        'status',
        'approved_by',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function approved()
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }
}
