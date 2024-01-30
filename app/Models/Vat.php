<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Vat extends Model
{ 
    protected $fillable = [
        'vatId',
        'rate',
        'vatType', 
        'companyId', 
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'vatId';
    public $timestamps = false;
    protected $table = 'vat';
}
