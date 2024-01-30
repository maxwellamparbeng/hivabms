<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAllowance extends Model
{ 
    protected $fillable = [
    'empalId',
    'employeeId',		
	'deductionId',			
	'type',					
	'amount',				
	'effectiveDate',			
	'dateCreated' ,
        
    ];
   

    protected $primaryKey = 'empalId';
    public $timestamps = true;
    protected $table = 'employee_allowances';
    public $incrementing = false;
}




	