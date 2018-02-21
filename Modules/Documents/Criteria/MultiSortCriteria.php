<?php

namespace Modules\Documents\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class MultiSortCriteria.
 *
 * @package namespace Modules\Documents\Criteria;
 */
class MultiSortCriteria implements CriteriaInterface
{
    use \Modules\Documents\Http\Helpers\RequestParser;
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
        $request = app()->make('request');
        return $this->getRequestFields($request, $model);
    }
}
