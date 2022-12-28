<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    
    protected $guard = 'admin';

    protected $table = "admins";
    protected $guarded = [];
    public $timestamps = true;




    
  //////////// Relations \\\\\\\\\\\\

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id' , 'id');
    }

    public function hasAbility($permissions)   
    {
        $role = $this->role;

        if (!$role) {
            return false;
        }

        foreach ($role->permissions as $permission) {
            if (is_array($permissions) && in_array($permission, $permissions)) {
                return true;
            } else if (is_string($permissions) && strcmp($permissions, $permission) == 0) {
                return true;
            }
        }
        return false;
    }

}
