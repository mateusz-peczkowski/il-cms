<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Option extends Model
{
    protected $table = 'options';
    public $timestamps = true;
    use LogsActivity;

    protected $fillable = [
        'type', 'key', 'value', 'locale', 'who_updated'
    ];

    protected static $logAttributes = ['type', 'key', 'value'];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
