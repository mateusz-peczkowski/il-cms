<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginAttempts extends Model {

    protected $table = 'login_attempts';
    public $timestamps = true;

    protected $fillable = [
        'user_email', 'status', 'login_ip'
    ];
}