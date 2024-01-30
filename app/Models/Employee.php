<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Employee extends Model
{ 
    protected $fillable = [
        'name',
        'email',
        'phoneNumber',
        'dateOfBirth',
        'empCode',
        'hireDate',
        'eduId',
        'deptId',
        'jobId',
        'salaryId',
        'endDate',
        'companyId'  
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'employeeId';
    public $timestamps = true;
    protected $table = 'employee';
    public $incrementing = false;
}
