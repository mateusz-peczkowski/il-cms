<?php

namespace App\Services\SectionFields;

//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection;
use Mockery\Exception;

class SectionFields
{
    protected $sections;
    protected $field;
    protected $parsed;

    private function __construct($sections)
    {
        $this->section = $sections;
    }

    public static function parseSections(Collection $sections)
    {
        $sectionInstance = new static($sections);
        foreach ($sections as $section) {
            $parsed[] = $sectionInstance->getField($section);
        }

        return implode('', $parsed);
    }

    private function getField($section)
    {
        return $this->getFieldInstance($section);
    }

    protected function getFieldInstance($section) {
        if (empty($section->type)) {
            throw new Exception('Field type cannot be empty!');
        }

        $app = app();
        $field = $app->makeWith('App\Services\SectionFields\Fields\\' . $section->type, ['field' => $section]);

        $form = $field->renderFormView();
        return $form;
    }


}