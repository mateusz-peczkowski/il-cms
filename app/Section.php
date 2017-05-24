<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';
    public $timestamps = true;

    protected $fillable = [
        'title', 'header', 'view', 'who_updated'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

    public function contentFields() {
        return $this->hasMany('App\SectionContentField', 'id', '');
    }
}