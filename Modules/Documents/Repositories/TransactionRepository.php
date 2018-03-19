<?php

namespace Modules\Documents\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TransactionRepository.
 *
 * @package namespace Modules\Documents\Repositories;
 */
interface TransactionRepository extends RepositoryInterface
{
	public function getByOffice($id);
	public function getByTask($task);
	public function getByDocument($id);
	public function pending();
	public function notPending();
    public function latest();
    public function store($request, $document_id, $doctype_id);
}
