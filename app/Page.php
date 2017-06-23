<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
    public $timestamps = true;

    protected $fillable = [
        'name', 'description', 'thumbnail', 'url', 'tag', 'controller', 'view', 'status', 'order', 'who_updated', 'locale'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

    public function sections() {
        return $this->hasManyThrough('App\Section', 'App\PageSection', 'page_id', 'id', 'id');
    }

}
