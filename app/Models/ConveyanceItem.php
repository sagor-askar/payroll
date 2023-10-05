<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConveyanceItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'conveyance_id',
        'description',
        'from_place',
        'to_place',
        'mode_of_transport',
        'cost'
    ];
}
