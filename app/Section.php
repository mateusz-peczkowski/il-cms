<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $casts = [
        'options' => 'json'
    ];

    protected $fillable = [
        'title', 'header', 'content', 'options', 'type', 'who_updated', 'status'
    ];

    public function page() {
        return $this->belongsToMany('App\Page', 'page_sections');
    }

    public function module() {
        return $this->belongsToMany('App\Module', 'module_sections');
    }

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }
}
