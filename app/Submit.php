<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submit extends Model
{
    protected $table = 'submit';
    public $timestamps = true;

    protected $fillable = [
        'form_id', 'data', 'ip', 'language'
    ];

}
