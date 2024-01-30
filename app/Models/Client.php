<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Client extends Model
{ 
    protected $fillable = [
        'fullname',
        'emailAddress',
        'phoneNumber',
        'Status', 
        'gender',
        'dob',
        'dateCreated',
        'companyId',
        'branchId',
        'contactgroupId',
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'clientId';
    public $timestamps = false;
    protected $table = 'clients';
    public $incrementing = false;
}
