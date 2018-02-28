<?php
namespace Modules\Documents\Http\ViewComposers;
use Illuminate\View\View;
class ActionsComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $actions;
    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->actions = config('documents.actions');
    }
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $actions = $this->actions;
        $view->with(compact('actions'));
    }
}
