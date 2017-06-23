<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Contracts\NavigationRepositoryInterface;

class NavigationComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $navigations;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $navigations
     * @return void
     */
    public function __construct(NavigationRepositoryInterface $navigations)
    {
        // Dependencies automatically resolved by service container...
        $this->navigations = $navigations;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('cms_navigations', $this->navigations->getActive());
    }
}