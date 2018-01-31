<?php

namespace App\Policies;

use Modules\Users\Entities\User;
use App\Modules\Users\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsersPolicy
{
    use HandlesAuthorization;

    /**
     * Authorize administrators to perform any action.
     * @param  [type] $user    User
     * @param  [type] $ability [description]
     * @return [type]          [description]
     */
    public function before($user, $ability)
    {
        if ($user->role === 1) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Modules\Users\Entities\User  $user
     * @param  \App\Modules\Users\Entities\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Modules\Users\Entities\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\Users\Entities\User  $user
     * @param  \App\Modules\Users\Entities\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->id === auth()->user()->id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\Users\Entities\User  $user
     * @param  \App\Modules\Users\Entities\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        //
    }
}
