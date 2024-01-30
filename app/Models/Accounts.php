<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Accounts extends Model
{ 
    protected $fillable = [
        'accountId',
        'name',
        'description',
        'createdBy',
        'dateCreated',
        'companyId',
        'updated_at',
        'created_at',
        
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'accountId';
    public $timestamps = true;
    protected $table = 'accounts';
    public $incrementing = false;
}
