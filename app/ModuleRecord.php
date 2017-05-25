<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleRecord extends Model
{
    protected $table = 'module_records';
    public $timestamps = true;

    protected $fillable = [
        'title', 'data', 'module_id', 'who_updated', 'status', 'slug', 'order', 'locale'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
