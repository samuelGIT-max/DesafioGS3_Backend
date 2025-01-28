<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'profile_id'];

    protected $hidden = ['password'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
