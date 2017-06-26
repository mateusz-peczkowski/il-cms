<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Module extends Model
{
    protected $table = 'modules';
    public $timestamps = true;
    use LogsActivity;

    protected $fillable = [
        'title', 'slug', 'structure', 'order', 'who_updated', 'status', 'has_details', 'order_records', 'order_records_type'
    ];

    protected static $logAttributes = ['title', 'structure', 'order', 'status', 'has_details', 'order_records', 'order_records_type'];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
