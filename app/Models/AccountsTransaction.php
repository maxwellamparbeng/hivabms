<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class AccountsTransaction extends Model
{ 
    protected $fillable = [
        'accountTransactionsId',
        'accountId',
        'amount',
        'transDescription',
        'transType',
        'createdBy',
        'dateCreated',
        'companyId',
        'branchId',
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $primaryKey = 'accountTransactionsId';
    public $timestamps = true;
    protected $table = 'account_transactions';
    public $incrementing = false;
}
