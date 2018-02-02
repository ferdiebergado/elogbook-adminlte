<?php

namespace Modules\Documents\Policies;

use Modules\Users\Entities\User;
use App\Modules\Documents\Entities\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
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
     * Determine whether the user can view the document.
     *
     * @param  \Modules\Users\Entities\User  $user
     * @param  \App\Modules\Documents\Entities\Document  $document
     * @return mixed
     */
    public function view(User $user, Document $document)
    {
        return ($user->id === auth()->user()->id);
    }

    /**
     * Determine whether the user can create documents.
     *
     * @param  \Modules\Users\Entities\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return ($user->id === auth()->user()->id);
    }

    /**
     * Determine whether the user can update the document.
     *
     * @param  \Modules\Users\Entities\User  $user
     * @param  \App\Modules\Documents\Entities\Document  $document
     * @return mixed
     */
    public function update(User $user, Document $document)
    {
        return ($user->id === auth()->user()->id) && ($document->creator === $user->id);        
    }

    /**
     * Determine whether the user can delete the document.
     *
     * @param  \Modules\Users\Entities\User  $user
     * @param  \App\Modules\Documents\Entities\Document  $document
     * @return mixed
     */
    public function delete(User $user, Document $document)
    {
        return false;
    }
}
