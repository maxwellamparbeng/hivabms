<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Salary extends Model
{ 
    protected $fillable = [
        'salaryName',
        'salaryId',
        'companyId'  
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'salaryId';
    public $timestamps = true;
    protected $table = 'salary';
    public $incrementing = false;
}
