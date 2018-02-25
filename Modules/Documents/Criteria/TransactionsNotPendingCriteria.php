<?php

namespace Modules\Documents\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class TransactionNotPendingCriteria.
 *
 * @package namespace Modules\Documents\Criteria;
 */
class TransactionsNotPendingCriteria implements CriteriaInterface
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
        return $model->where('pending', 0);
    }
}
