<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ExpenseCategory extends Model
{ 
    protected $fillable = [
        'expenseCatName',
        'expenseCategoryId',
        'branchId',
        'updated_at',
        'created_at',
        'companyId' ,
        'catDescription' 
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'expenseCategoryId';
    public $timestamps = true;
    protected $table = 'expense_category';
    public $incrementing = false;
}
