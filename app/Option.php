<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';
    public $timestamps = true;

    protected $fillable = [
        'type', 'key', 'value', 'locale', 'who_updated'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
