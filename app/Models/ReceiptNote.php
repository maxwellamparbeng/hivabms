<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ReceiptNote extends Model
{ 
    protected $fillable = [
        'noteId',
        'note',
        'companyId', 
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'noteId';
    public $timestamps = false;
    protected $table = 'receiptnote';
}
