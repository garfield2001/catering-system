<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;

class AdminUser extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    protected $table = 'admin_users';
    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "phone",
        "username",
        "password",
        "remember_token",  
        "created_at",
        "updated_at"
    ];
}   

