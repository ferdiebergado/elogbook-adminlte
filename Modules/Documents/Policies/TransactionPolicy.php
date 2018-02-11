<?php
namespace Modules\Documents\Policies;
use Modules\Users\Entities\User;
use Modules\Documents\Entities\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;
class TransactionPolicy
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
     * Determine whether the user can view the transaction.
     *
     * @param  \Modules\Users\Entities\User  $user
     * @param  \App\Modules\Documents\Entities\Transaction  $transaction
     * @return mixed
     */
    public function view(User $user, Transaction $transaction)
    {
        return $user->id === auth()->user()->id;
    }
    /**
     * Determine whether the user can create transactions.
     *
     * @param  \Modules\Users\Entities\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->id === auth()->user()->id;
    }
    /**
     * Determine whether the user can update the transaction.
     *
     * @param  \Modules\Users\Entities\User  $user
     * @param  \App\Modules\Documents\Entities\Transaction  $transaction
     * @return mixed
     */
    public function update(User $user, Transaction $transaction)
    {
        return $user->id === auth()->user()->id;
    }
    /**
     * Determine whether the user can delete the transaction.
     *
     * @param  \Modules\Users\Entities\User  $user
     * @param  \App\Modules\Documents\Entities\Transaction  $transaction
     * @return mixed
     */
    public function delete(User $user, Transaction $transaction)
    {
        return false;
    }
}
