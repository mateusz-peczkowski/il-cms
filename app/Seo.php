<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Seo extends Model
{
    protected $table = 'seos';
    public $timestamps = true;
    use LogsActivity;

    protected $fillable = [
        'model', 'model_id', 'meta_title', 'meta_keys', 'meta_description', 'page_head', 'page_footer', 'who_updated'
    ];

    protected static $logAttributes = ['model', 'model_id', 'meta_title', 'meta_keys', 'meta_description', 'page_head', 'page_footer'];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
