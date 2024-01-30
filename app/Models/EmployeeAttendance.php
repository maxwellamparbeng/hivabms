<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class EmployeeAttendance extends Model
{ 
    protected $fillable = [
    'empAttendanceId',
    'employeeId',		
	'payrollId',			
	'noDays',					
    
    ];
   

    protected $primaryKey = 'empAttendanceId';
    public $timestamps = true;
    protected $table = 'employeeattendance';
    public $incrementing = false;
}



