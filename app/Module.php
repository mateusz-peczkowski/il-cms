<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Module extends Model
{
    protected $table = 'modules';
    public $timestamps = true;

    protected $fillable = [
        'title', 'slug', 'structure', 'order', 'who_updated', 'status', 'has_details', 'order_records', 'order_records_type'
    ];

    public function updater() {
        return $this->hasOne('App\User', 'id', 'who_updated');
    }

    public function sections() {
        return DB::table('sections')->join('module_sections', 'sections.id', '=', 'module_sections.section_id')->select('sections.*')->where('module_sections.module_id', '=', $this->id)->get();
    }
}
