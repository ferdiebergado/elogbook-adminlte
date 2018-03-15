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
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
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
        if ($this->request->has('orderByMulti')) {
           $request = (string) $this->request->orderByMulti;
            $fields = explode(';', $request);
            $dirs = explode(';', $request);
            $i = 0;
            foreach($fields as $field) {
                $model->orderBy($field, $dirs[$i]);
                $i++;
            }
        } 
        if (empty($this->request->sortBy))  {
            $model = $repository->latest();
        }
        return $model;  
    }
}
