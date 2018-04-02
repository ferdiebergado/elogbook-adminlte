<?php

namespace Modules\Documents\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Documents\Entities\Office;

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
        return $this->model->whereHas('users', function ($q) {
            $q->where('role', 3)->where('confirmed', 1)->where('active', 1);
        })->select('id')->orderBy('id')->get();
    }
}
