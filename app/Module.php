<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';
    public $timestamps = true;

    protected $fillable = [
        'title', 'slug', 'structure', 'order', 'who_updated', 'status', 'has_details', 'order_records', 'order_records_type'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

    public function sections() {
        return $this->hasManyThrough('App\Section', 'App\ModuleSection', 'module_id', 'id', 'id');
    }

}
