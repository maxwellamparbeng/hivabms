<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{ 
    protected $fillable = [
    'id',
    'ref_no',
    'date_from',
    'date_to',
    'type',
    'status',
    'companyId', 
    'createdBy'
    ];
    
    protected $primaryKey = 'payrollId';
    public $timestamps = true;
    protected $table = 'payroll';
    public $incrementing = false;
}
