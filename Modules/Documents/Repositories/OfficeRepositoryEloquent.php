<?php

namespace Modules\Documents\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Documents\Repositories\OfficeRepository;
use Modules\Documents\Entities\Office;
use Modules\Documents\Validators\OfficeValidator;

/**
 * Class OfficeRepositoryEloquent.
 *
 * @package namespace Modules\Documents\Repositories;
 */
class OfficeRepositoryEloquent extends BaseRepository implements OfficeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Office::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function getActive()
    {
        return $this->model->has('users')->select('id')->orderBy('id')->get();
    }    
}
