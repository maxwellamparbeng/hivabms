<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{ 
    protected $fillable = [
        'productId',
        'name', 
        'price',
        'supplier',
        'unit',
        'qty',
        'expirydate',
        'description',
        'date',
        'companyId',
        'Status',
        'cprice',
        'bwhprice',
        'whprice',
        'pbwhprice',
        'rprice',
        'prprice',
        'barcode',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

   
    protected $primaryKey = 'productId';
    public $timestamps = false;
    protected $table = 'products';
    public $incrementing = false;
}
