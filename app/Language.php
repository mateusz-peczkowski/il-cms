<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Language extends Model
{
    protected $table = 'languages';
    public $timestamps = true;
    use LogsActivity;

    protected $fillable = [
        'title', 'slug', 'is_default', 'status', 'who_updated', 'order'
    ];

    protected static $logAttributes = ['title', 'slug', 'is_default', 'status', 'order'];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
