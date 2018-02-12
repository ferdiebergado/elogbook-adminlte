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
    private $task;
    public function __construct($task)
    {
        $this->task = $task;
    }
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
        return $model->where('task', $this->task)->where('pending', 0);
    }
}
