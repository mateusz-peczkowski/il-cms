<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'forms';
    public $timestamps = true;

    protected $fillable = [
        'title', 'tag', 'type', 'description', 'sender_name', 'sender_email', 'confirmation', 'status', 'who_updated'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

    public function submits() {
        return $this->hasMany('App\Submit', 'form_id', 'id');
    }

}
