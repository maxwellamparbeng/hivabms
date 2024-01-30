<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class InventoryLog extends Model
{ 
    protected $fillable = [
        'inventoryId',
        'productId',
        'inventoryQuantityBefore',
        'inventoryQuantityAfter',
        'companyId',
        'branchId',
        'inventorylogId',
        'dateCreated',
        'userId',
        'transactionId',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'inventorylogId';
    public $timestamps = true;
    protected $table = 'inventorylog';
}
