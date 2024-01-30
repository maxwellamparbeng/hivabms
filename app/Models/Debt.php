<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Debt extends Model
{ 
    protected $fillable = [
        'debtId',
        'name',
        'amountOwed',
        'amountPaid',
        'branchId',
        'description',
        'createdBy',
        'dateCreated',
        'companyId',
        'updated_at',
        'created_at',
        'status',
        
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'debtId';
    public $timestamps = true;
    protected $table = 'debt';
    public $incrementing = false;
}
