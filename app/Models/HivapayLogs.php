<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Hivapaylogs extends Model
{ 
    protected $fillable = [
        'id',
        'transactionId',
        'status',
        'code',
        'message',
        'date',
        'verified',
        'referenceId',
        'userId',
        'amount',
        'updated_at',
        'created_at',
        'companyId',
        'branchId'
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $table = 'hivapaylogs';
    public $incrementing = false;
}
