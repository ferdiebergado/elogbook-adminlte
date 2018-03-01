<?php

namespace Modules\Documents\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OfficeRepository.
 *
 * @package namespace Modules\Documents\Repositories;
 */
interface OfficeRepository extends RepositoryInterface
{
    public function getActive();
}
