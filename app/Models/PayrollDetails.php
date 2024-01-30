<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollDetails extends Model
{ 
    protected $fillable = [
    'id',
    'payroll_id',
    'employee_id',
    'present',
    'absent',
    'late',
    'salary', 
    'allowance_amount',
    'allowances',
    'deduction_amount',
    'deductions',
    'net',
    'date_created',
    'taxablePay',
    'incomeTax',
    'ssnit',
    'createdBy'
    ];
    
    protected $primaryKey = 'payroll_id';
    public $timestamps = true;
    protected $table = 'payroll_items';
    public $incrementing = false;
}
