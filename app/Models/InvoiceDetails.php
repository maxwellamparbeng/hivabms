<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class InvoiceDetails extends Model
{ 
    protected $fillable = [
        'id',
        'transactionId',
        'productId',
        'price',
        'detailsQuantity',
        'companyId',
        'userId',
         // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $table = 'invoice_transaction_details';
}
