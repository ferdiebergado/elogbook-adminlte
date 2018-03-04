<?php

namespace Modules\Documents\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class TransactionsByDocumentCriteria.
 *
 * @package namespace Modules\Documents\Criteria;
 */
class TransactionsByUserCriteria implements CriteriaInterface
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
        return $model->with(['document', 'document.doctype', 'creator', 'editor'])->whereHas('creator', function($query) {
            $query->where('office_id', auth()->user()->office_id);
        })->orWhereHas('editor', function($query) {
            $query->where('office_id', auth()->user()->office_id);
        });
    }
}
