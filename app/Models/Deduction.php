<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Deduction extends Model
{ 
    protected $fillable = [
        'deductionId',
        'deduction',
        'description',
        'companyId'  
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'deductionId';
    public $timestamps = true;
    protected $table = 'deductions';
    public $incrementing = false;
}
