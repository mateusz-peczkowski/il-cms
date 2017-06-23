<?php
namespace App\Services\SectionFields\Fields;

class EmbedHtml extends AbstractField
{
    public $field;

    public function __construct($field)
    {
        $this->field = $field;
    }

}