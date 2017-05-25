<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Contracts\ModuleRepositoryInterface;

class ModuleComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $modules;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $modules
     * @return void
     */
    public function __construct(ModuleRepositoryInterface $modules)
    {
        // Dependencies automatically resolved by service container...
        $this->modules = $modules;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('cms_modules', $this->modules->getActive());
    }
}