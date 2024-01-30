<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class InvoiceCart extends Model
{ 
    protected $fillable = [
        'cartId',
        'price',
        'cartQuantity',
        'productId',
        'companyId',
        'userId',
       
        
        
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'cartId';
    public $timestamps = false;
    protected $table = 'invoicecart';
}
