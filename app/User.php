<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'role', 'image'
    ];
    public $timestamps = true;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function user_role() {
        return $this->hasOne('App\Role', 'id', 'role');
    }

    public function last_attmept_success() {
        return $this->hasMany('App\LoginAttempts', 'user_email', 'email')->where('status', 'success')->latest();
    }

    public function last_attmept_error() {
        return $this->hasMany('App\LoginAttempts', 'user_email', 'email')->where('status', 'error')->latest();
    }
}
