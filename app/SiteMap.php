<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SiteMap extends Model
{
    protected $table = 'sitemap_options';
    public $timestamps = true;
    use LogsActivity;

    protected $fillable = [
        'url', 'media', 'element_type', 'update_frequency', 'priorty', 'translations', 'who_updated', 'status'
    ];

    protected static $logAttributes = ['url', 'media', 'element_type', 'update_frequency', 'prioty', 'translations'];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
