<?php

namespace Modules\Auth\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Auth\Entities\Login;
use Modules\Users\Entities\User;
use Illuminate\Support\Facades\DB;
use Session;
class LoginListener
{
    protected $logins, $users;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Login $login, User $user)
    {
        $this->logins = $login;
        $this->users = $user;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        DB::beginTransaction();
        try {
            $login = $this->logins->create([
                'user_id'   => $event->user->id,
                'ip'        => request()->ip(),
                'user_agent' => request()->userAgent(),
                'via_remember' => $event->remember
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage())->withInput(request()->except(['password', 'password_confirmation', 'old_password', '_token']));
        }
        try {
            $user = $this->users->find($login->user_id);
            $user->update(['last_login' => $login->created_at]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage())->withInput(request()->except(['password', 'password_confirmation', 'old_password', '_token']));    
        }
        DB::commit();
    }
}
