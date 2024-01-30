<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ContactGroup extends Model
{ 
    protected $fillable = [
        'contactGroupId',
        'companyId',
        'name',
        'dateCreated',
        'status',
       
        
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'contactGroupId';
    public $timestamps = false;
    protected $table = 'contact_group';
    public $incrementing = false;
}
