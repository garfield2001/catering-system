<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminUser extends Model implements Authenticatable
{
    use AuthenticatableTrait, HasFactory, HasUlids;
    protected $primaryKey = 'id'; // Assuming 'id' is the ULID column name
    protected $keyType = 'string'; // Specify the key type as string
    public $incrementing = false; // ULID is not auto-incrementing

    
    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "phone",
        "username",
        "password"
    ];
}   

