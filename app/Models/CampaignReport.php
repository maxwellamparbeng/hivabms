<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CampaignReport extends Model
{ 
    protected $fillable = [
        'campaignType',
        'category',
        'totalSent',
        'status', 
        'dateCreated',
        'campaignId',
        'apiResponse',
        'companyId',
        'message'
        
        
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'campaignId';
    public $timestamps = false;
    protected $table = 'campaignreport';
    public $incrementing = false;
}
