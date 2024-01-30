<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Invoice extends Model
{ 
    protected $fillable = [
        'invoiceId',
        'companyId',
        'amount',
        'customerName',
        'email',
        'phoneNumber',
        'address',
        'paymentStatus',
        'invoiceType',
        'created_at',
        'updated_at',
        'status',
        'note',
        'paymentType',
        'branchId',
        'discount',
        'vat',
        'discountPercentage',
        'vatPercentage'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'invoiceId';
    public $timestamps = true;
    protected $table = 'invoice';
}
