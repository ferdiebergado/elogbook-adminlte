<?php

namespace Modules\Documents\Http\ViewComposers;

use Illuminate\View\View;
use Modules\Documents\Entities\Office;
use Illuminate\Contracts\Cache\Repository;

class ActiveOfficesCountComposer
{
    private $offices;
    private $cache;

    /**
    * Create a new office count composer.
    *
    * @return void
    */
    public function __construct(Office $office, Repository $cache)
    {
        // Dependencies automatically resolved by service container...
        $this->offices = $office;
        $this->cache = $cache;
    }

    /**
    * Bind data to the view.
    *
    * @param  View  $view
    * @return void
    */
    public function compose(View $view)
    {
        $active_offices_count = $this->cache->remember('active_offices_count', '30', function () {
            return $this->offices->whereHas('users', function ($q) {
                $q->where('role', 3)->where('confirmed', 1)->where('active', 1);
            })->count();
        });
        $view->with(compact('active_offices_count'));
    }
}
