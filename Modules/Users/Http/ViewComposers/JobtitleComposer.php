<?php

namespace Modules\Users\Http\ViewComposers;

use Illuminate\View\View;
use Modules\Users\Entities\Jobtitle;
use Illuminate\Support\Facades\Cache;

class JobtitleComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $jobtitles;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(Jobtitle $jobtitle)
    {
        // Dependencies automatically resolved by service container...
        $this->jobtitles = $jobtitle;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $jobtitles = $this->jobtitles->orderBy('name')->get();
        $view->with(compact('jobtitles'));
    }
}