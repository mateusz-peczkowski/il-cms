<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = [
        'page_id', 'section_id'
    ];

    public $timestamps = true;
}
