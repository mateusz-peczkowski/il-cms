<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Page extends Model
{
    protected $table = 'pages';
    public $timestamps = true;
    use LogsActivity;

    protected $fillable = [
        'name', 'description', 'thumbnail', 'url', 'tag', 'controller', 'view', 'status', 'order', 'who_updated', 'locale'
    ];

    protected static $logAttributes = ['name', 'description', 'thumbnail', 'url', 'tag', 'controller', 'view', 'status', 'order'];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
