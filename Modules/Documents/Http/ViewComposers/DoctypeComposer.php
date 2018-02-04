<?php

namespace Modules\Documents\Http\ViewComposers;

use Illuminate\View\View;
use Modules\Documents\Entities\Doctype;

class DoctypeComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $doctypes;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(Doctype $doctype)
    {
        // Dependencies automatically resolved by service container...
        $this->doctypes = $doctype;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $doctypes = $this->doctypes->all()->sortBy('name');
        $view->with(compact('doctypes'));
    }
}