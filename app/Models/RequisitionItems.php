<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionItems extends Model
{
    use HasFactory;

    public $table = 'requisition_items';

    protected $fillable = [
        'requisition_id',
        'name',
        'qty',
        'unit_price',
        'description',
        'created_by',
        'updated_at',
    ];
    public function employee()
    {
        return $this->belongsTo(Requisition::class, 'requisition_id');
    }

}
