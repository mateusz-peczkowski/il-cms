<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $table = 'seos';
    public $timestamps = true;

    protected $fillable = [
        'model', 'model_id', 'meta_title', 'meta_keys', 'meta_description', 'page_head', 'page_footer', 'who_updated'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

}
