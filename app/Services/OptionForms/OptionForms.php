<?php

namespace App\Services\OptionForms;

use App\Repositories\Contracts\OptionRepositoryInterface;
use App\Services\Contracts\OptionFormsInterface;
use Collective\Html\FormBuilder;

class OptionForms implements OptionFormsInterface
{
    protected $option;
    protected $optionType;
    protected $builder;

    /**
     * OptionForms constructor
     */
    public function __construct(OptionRepositoryInterface $option, FormBuilder $builder)
    {
        $this->option = $option;
        $this->optionType = $option->type;
        $this->builder = $builder;
    }

    public function render()
    {

    }



}