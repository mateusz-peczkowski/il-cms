<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $table = 'language_translations';
    public $timestamps = true;

    protected $fillable = [
        'key', 'value', 'status', 'who_updated', 'locale'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
