<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Form extends Model
{
    protected $table = 'forms';
    public $timestamps = true;
    use LogsActivity;

    protected $fillable = [
        'title', 'tag', 'type', 'description', 'sender_name', 'sender_email', 'confirmation', 'status', 'who_updated', 'locale'
    ];

    protected static $logAttributes = ['title', 'tag', 'type', 'description', 'sender_name', 'sender_email', 'confirmation', 'status', 'who_updated'];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

    public function submits() {
        return $this->hasMany('App\Submit', 'form_id', 'id');
    }

    public function controls() {
        return $this->hasMany('App\Control', 'form_id', 'id');
    }

    public function controls_active() {
        return $this->hasMany('App\Control', 'form_id', 'id')->where('status', '=', 1);
    }

    public function last_submit() {
        return $this->hasMany('App\Submit', 'form_id', 'id')->orderBy('id', 'desc');
    }

}
