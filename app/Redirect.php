<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Redirect extends Model
{
    protected $table = 'redirects';
    public $timestamps = true;
    use LogsActivity;

    protected $fillable = [
        'from', 'to', 'status', 'who_updated'
    ];

    protected static $logAttributes = ['from', 'to', 'status'];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
