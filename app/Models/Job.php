<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Job extends Model
{ 
    protected $fillable = [
        'jobName',
        'jobId',
        'companyId'  
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'jobId';
    public $timestamps = true;
    protected $table = 'job';
    public $incrementing = false;
}
