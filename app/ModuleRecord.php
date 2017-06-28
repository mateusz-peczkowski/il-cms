<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ModuleRecord extends Model
{
    protected $table = 'module_records';
    public $timestamps = true;
    use LogsActivity;

    protected $fillable = [
        'title', 'data', 'section_data', 'module_id', 'who_updated', 'status', 'slug', 'order', 'locale'
    ];

    protected static $logAttributes = ['title', 'data', 'module_id', 'status', 'order'];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
