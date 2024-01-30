<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ProductsCategory extends Model
{ 
    protected $fillable = [
        'companyId',
        'categoryId',
        'catName',
        'catPic', 
        'date',
      
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'categoryId';
    public $timestamps = false;
    protected $table = 'productscategory';
    public $incrementing = false;
}
