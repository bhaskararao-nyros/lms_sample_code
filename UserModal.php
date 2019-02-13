<?php

namespace App\Modules\Users;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $table = 'users_tb';
    protected $fillable = ['email', 'name', 'password', 'phone', 'role_as'];
}