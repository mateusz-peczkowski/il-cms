<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\DB;

class Module extends Model
{
    protected $table = 'modules';
    public $timestamps = true;
    use LogsActivity;

    protected $fillable = [
        'title', 'slug', 'structure', 'sections_structure', 'order', 'who_updated', 'status', 'has_details', 'order_records', 'order_records_type'
    ];

    protected $casts = [
        'structure' => 'json',
        'sections_structure' => 'json'
    ];

    protected static $logAttributes = ['title', 'structure', 'order', 'status', 'has_details', 'order_records', 'order_records_type'];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
