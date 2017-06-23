<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $casts = [
        'options' => 'json'
    ];

    public function page() {
        return $this->belongsToMany('App\Page', 'page_sections');
    }

    public function module() {
        return $this->belongsToMany('App\Module', 'module_sections');
    }
}
