<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Expense extends Model
{ 
    protected $fillable = [
        'expenseName',
        'expenseId',
        'branchId',
        'updated_at',
        'created_at',
        'companyId' ,
        'categoryId',
        'description',
        'amount' 
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'expenseId';
    public $timestamps = true;
    protected $table = 'expense';
    public $incrementing = false;
}
