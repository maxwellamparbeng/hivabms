<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class RolePermissions extends Model
{ 
    protected $fillable = [
        'permission_id',
        'role_id', 
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

   
    protected $primaryKey = 'permission_id';
    public $timestamps = false;
    protected $table = 'role_has_permissions';
    public $incrementing = false;
}
