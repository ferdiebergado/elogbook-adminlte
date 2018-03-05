<?php

namespace Modules\Documents\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class TransactionsByTaskCriteria.
 *
 * @package namespace Modules\Documents\Criteria;
 */
class TransactionsByTaskCriteria implements CriteriaInterface
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
        if (($task === 'I') || ($task === 'O')) {
            return $this->model->where('task', $task)->where('pending', 0);
        }
        if ($task === 'P') {
            return $this->model->where('pending', 1);
        }   
    }
}
