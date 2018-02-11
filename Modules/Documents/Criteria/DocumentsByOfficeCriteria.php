<?php
namespace Modules\Documents\Criteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
/**
 * Class DocumentsByOfficeCriteria.
 *
 * @package namespace Modules\Documents\Criteria;
 */
class DocumentsByOfficeCriteria implements CriteriaInterface
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
        if (auth()->user()->role !== 1) {
            return $model->where('office_id', auth()->user()->office_id);
        }        
        return $model;
    }
}
