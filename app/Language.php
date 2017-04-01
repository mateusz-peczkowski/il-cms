<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';
    public $timestamps = true;

    protected $fillable = [
        'title', 'slug', 'is_default', 'status', 'who_updated', 'order'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
