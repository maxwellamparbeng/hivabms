<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDeductions extends Model
{ 
    protected $fillable = [
    'empdeId',
    'employeeId',		
	'allowanceId',			
	'type',					
	'amount',				
	'effectiveDate',			
	'dateCreated' ,
        
    ];
   

    protected $primaryKey = 'empdeId';
    public $timestamps = true;
    protected $table = 'employee_deductions';
    public $incrementing = false;
}




	