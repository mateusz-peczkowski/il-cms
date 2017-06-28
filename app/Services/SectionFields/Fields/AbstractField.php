<?php
/**
 * Created by PhpStorm.
 * User: tomasz.urban
 * Date: 23.06.2017
 * Time: 10:36
 */

namespace App\Services\SectionFields\Fields;


abstract class AbstractField
{
    protected $field;

    public function renderFormView()
    {
        return view('cmsbackend.sections.fields.' . $this->field->type, ['section' => $this->field]);
    }

    public function renderFrontView()
    {
        return view('cmsfront.sections.fields.' . $this->field['fieldType'], ['section' => $this->field]);
    }

}