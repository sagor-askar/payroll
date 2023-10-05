<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    public $table = 'assets';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'asset_code',
        'qty',
        'group_id',
        'purchase_date',
        'warranty_period',
        'unit_price',
        'supplier_name',
        'supplier_phone',
        'supplier_address',
        'description',
        'assigned_employee_id',
        'created_at',
        'updated_at',
    ];

    public function assigned_employee()
    {
        return $this->belongsTo(Employee::class, 'assigned_employee_id');
    }

    public function asset_group()
    {
        return $this->belongsTo(AssetGroup::class, 'group_id');
    }
}
