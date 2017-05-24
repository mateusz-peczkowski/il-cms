<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionContentField extends Model
{
    protected $table = 'section_content_fields';
    public $timestamps = true;

    protected $fillable = [
        'type', 'key', 'value', 'locale', 'who_updated'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

    public function section() {
        return $this->belongsTo('App\Section');
    }
}
