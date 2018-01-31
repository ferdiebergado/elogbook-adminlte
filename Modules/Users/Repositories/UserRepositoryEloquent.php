<?php

namespace Modules\Users\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Users\Interfaces\UserRepository;
use Modules\Users\Entities\User;
// use Modules\Users\Validators\UserValidator;
use Illuminate\Support\Facades\Cache;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace Modules\Users\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        // return UserValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    /**
     * Fetch User by id
     * @param  [integer] $id [user id]
     * @return [collection]     [user]
     */
    public function getUserById($id)
    {
        return Cache::remember('user_{$id}', 60, function() use(&$id) {
            return $this->model->find($id);
        });
    }
    
}
