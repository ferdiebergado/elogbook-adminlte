<?php
namespace Modules\Users\Http\ViewComposers;
use Illuminate\View\View;
use Modules\Users\Entities\User;
use Illuminate\Support\Facades\Cache;
class UsersComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;
    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        // Dependencies automatically resolved by service container...
        $this->users = $user;
    }
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $users = Cache::remember('users', '30', function() {
            return $this->users->orderBy('name')->get(['id', 'name']);
        });            
        $view->with(compact('users'));
    }
}
