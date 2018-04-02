<?php

namespace Modules\Documents\Http\ViewComposers;

use Illuminate\View\View;
use Modules\Documents\Entities\Office;

class ActiveOfficesComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $offices;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(Office $office)
    {
        // Dependencies automatically resolved by service container...
        $this->offices = $office;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $active_offices = $this->offices->with(['bureauservice', 'strand', 'users' => function ($q) {
            $q->where('role', 3)->where('confirmed', 1)->where('active', 1);
        }])->has('users')->orderBy('name')->simplePaginate(5);
        $view->with(compact('active_offices'));
    }
}
