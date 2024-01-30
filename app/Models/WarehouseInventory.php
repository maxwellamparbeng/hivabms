<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class WarehouseInventory extends Model
{ 
    protected $fillable = [
        'inventoryId',
        'warehouseId',
        'productId',
        'companyId',
        'invQuantity',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $primaryKey = 'inventoryId';
    public $timestamps = true;
    protected $table = 'warehouseinventory';
    public $incrementing = false;
}
