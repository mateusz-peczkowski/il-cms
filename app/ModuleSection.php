<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleSection extends Model
{
    protected $fillable = [
        'module_id', 'section_id'
    ];
}
