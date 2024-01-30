<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Company extends Model
{ 
    protected $fillable = [
        'companyName',
        'companyDescription',
        'email',
        'phoneNumber',
        'Status', 
        'smsApikey',
        'smsApiusername',
        'senderName',
        'natureOfBusiness',
        'stockReduction',
        'logo',
        'ProductPricing',
        'posBarcodeScanner',
        'subscriptionTier',
        'tin',
        
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'companyId';
    public $timestamps = false;
    protected $table = 'company';
    public $incrementing = false;
}
