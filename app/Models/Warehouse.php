<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Warehouse extends Model
{ 
    protected $fillable = [
        'warehouseName',
        'warehouseId',
        'warehousePhone',
        'location',
        'updated_at',
        'created_at',
        'companyId'  
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    protected $primaryKey = 'warehouseId';
    public $timestamps = true;
    protected $table = 'warehouse';
    public $incrementing = false;
}
