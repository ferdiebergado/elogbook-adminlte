<?php
namespace Modules\Documents\Http\ViewComposers;
use Illuminate\View\View;
use Modules\Documents\Entities\Office;
class OfficeComposer
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
        $offices = $this->offices->all()->sortBy('name');
        $view->with(compact('offices'));
    }
}