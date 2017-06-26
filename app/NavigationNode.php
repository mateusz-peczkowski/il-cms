<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NavigationNode extends Model
{
    protected $table = 'navigation_nodes';
    public $timestamps = true;

    protected $fillable = [
        'title', 'navigation_id', 'page_id', 'parent_id', 'who_updated', 'order', 'locale'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }
    public function subnodes()
    {
        return $this->hasMany('App\NavigationNode', 'parent_id')->orderBy('order', 'asc');
    }


}
