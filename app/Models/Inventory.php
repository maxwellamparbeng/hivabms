<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Inventory extends Model
{ 
    protected $fillable = [
        'inventoryId',
        'branchId',
        'productId',
        'companyId',
        'invQuantity'
      
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'inventoryId';
    public $timestamps = true;
    protected $table = 'inventory';
    public $incrementing = false;
}
