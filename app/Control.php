<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Control extends Model
{
    protected $table = 'form_controls';
    public $timestamps = true;
    use LogsActivity;

    protected $fillable = [
        'name', 'label', 'type', 'default', 'values', 'required', 'form_id', 'status', 'who_updated', 'order'
    ];

    protected static $logAttributes = ['name', 'label', 'type', 'default', 'values', 'required', 'form_id', 'status', 'order'];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
