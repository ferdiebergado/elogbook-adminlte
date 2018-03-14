<?php

namespace Modules\Documents\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ByofficeCriteria.
 *
 * @package namespace Modules\Documents\Criteria;
 */
class ByOfficeCriteria implements CriteriaInterface
{
    private $office_id;

    public function __construct($office_id)
    {
        $this->$office_id = $office_id;
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
        return $model->where('office_id', $this->office_id);
    }
}
