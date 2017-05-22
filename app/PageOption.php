<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageOption extends Model
{
    protected $table = 'page_options';
    public $timestamps = true;

    protected $fillable = [
        'key', 'type', 'values', 'page_id', 'order', 'who_updated', 'status'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
