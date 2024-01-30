<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Department extends Model
{ 
    protected $fillable = [
        'deptName',
        'deptId',
        'companyId'  
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'deptId';
    public $timestamps = true;
    protected $table = 'department';
    public $incrementing = false;
}
