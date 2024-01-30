<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Branch extends Model
{ 
    protected $fillable = [
        'branchName',
        'branchId',
        'branchPhone',
        'location',
        'updated_at',
        'created_at',
        'companyId'  
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'branchId';
    public $timestamps = true;
    protected $table = 'branches';
    public $incrementing = false;
}
