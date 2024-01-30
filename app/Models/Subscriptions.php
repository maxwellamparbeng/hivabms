<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Subscriptions extends Model
{ 
    protected $fillable = [
        'subscriptionId',
        'TierSubscriptionsId',
        'dateCreated',
        'renewalDate',
        'status',
        'paymentStatus',
        'companyId',
       
        
        
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'subscriptionId';
    public $timestamps = false;
    protected $table = 'subscriptions';
}
