<?php
namespace Modules\Documents\Http\ViewComposers;
use Illuminate\View\View;
use Modules\Documents\Entities\Office;
use Illuminate\Support\Facades\Cache;
class ActiveOfficesCountComposer
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
        $active_offices_count = Cache::remember('active_offices_count', '30', function () {
            return $this->offices->with(['users'])->has('users')->count();
        });
        $view->with(compact('active_offices_count'));
    }
}
