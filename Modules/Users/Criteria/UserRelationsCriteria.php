<?php

namespace Modules\Users\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class UserRelationsCriteria.
 *
 * @package namespace Modules\Users\Criteria;
 */
class UserRelationsCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->with(['jobtitle', 'office']);
    }
}
