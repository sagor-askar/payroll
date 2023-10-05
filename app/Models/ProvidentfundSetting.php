<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvidentfundSetting extends Model
{
    use HasFactory;
    public $table = 'providentfund_settings';

    protected $fillable = [
        'status',
        'company_contribution_status'
    ];
}
