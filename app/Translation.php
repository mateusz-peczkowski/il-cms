<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $table = 'translations';
    public $timestamps = true;

    protected $fillable = [
        'key', 'value', 'status', 'who_updated'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
