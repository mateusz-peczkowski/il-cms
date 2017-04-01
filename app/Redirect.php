<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $table = 'redirects';
    public $timestamps = true;

    protected $fillable = [
        'from', 'to', 'status'
    ];

}
