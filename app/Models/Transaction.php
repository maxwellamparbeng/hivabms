<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Transaction extends Model
{ 
    protected $fillable = [
        'transactionId',
        'customer',
        'totalAmount',
        'tendered',
        'companyId',
        'userId',
        'email',
        'phone',
        'address',
        'paymentMethod',
        'branchId',
        'discount',
        'vat',
        'vatPercentage',
        'discountPercentage',
        'status',
        'dateCreated',
        'note',
      
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'transactionId';
    public $timestamps = true;
    protected $table = 'transactions';
}
