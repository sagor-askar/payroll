<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    use HasFactory;
    public $table = 'notice_boards';
    protected $fillable = [
        'employee_id',
        'department_id',
        'notice_title',
        'description',
        'notice_date',
        'is_seen',
        'seen_users',
        'created_by'
    ];
    protected $casts = [
        'seen_users' => 'array'
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
