<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Navigation extends Model
{
    protected $table = 'navigations';
    public $timestamps = true;
    use LogsActivity;

    protected $fillable = [
        'title', 'slug', 'tag', 'order', 'who_updated', 'status'
    ];

    protected static $logAttributes = ['title', 'slug', 'tag', 'order', 'status'];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

    public function nodes()
    {
        return $this->hasMany('App\NavigationNode')->where('parent_id', null)->orderBy('order', 'asc');
    }

}
