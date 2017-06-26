<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Translation extends Model
{
    use LogsActivity;

    protected $table = 'language_translations';
    public $timestamps = true;

    protected $fillable = [
        'key', 'value', 'status', 'who_updated', 'locale'
    ];

    protected static $logAttributes = ['key', 'value', 'status'];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
