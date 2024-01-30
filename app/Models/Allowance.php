<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Allowance extends Model
{ 
    protected $fillable = [
        'allowanceId',
        'allowance',
        'description',
        'companyId'  
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'allowanceId';
    public $timestamps = true;
    protected $table = 'allowances';
    public $incrementing = false;
}
