<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    protected $table = 'form_controls';
    public $timestamps = true;

    protected $fillable = [
        'name', 'label', 'type', 'default', 'values', 'required', 'form_id', 'status', 'who_updated'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
