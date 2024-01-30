<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class InventoryTransferLog extends Model
{ 
    protected $fillable = [
        'id',
        'frombranchId',
        'tobranchId',
        'productId',
        'companyId',
        'quantity',
        'dateCreated',
        'userId',
        'transferType',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'inventorytransferlog';
}
