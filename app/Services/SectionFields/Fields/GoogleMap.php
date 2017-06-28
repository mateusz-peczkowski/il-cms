<?php
namespace App\Services\SectionFields\Fields;

use Mapper;

class GoogleMap extends AbstractField
{
    public $field;

    public function __construct($field)
    {
        $this->field = $field;
        $this->field->map = $this->getMap();
    }

    protected function getMap()
    {
        return Mapper::location(isset($this->field->options['location']) ? $this->field->options['location'] : 'default')->map();
    }

}