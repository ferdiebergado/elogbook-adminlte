<?php

namespace Modules\Users\Interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository.
 *
 * @package namespace Modules\Users\Interfaces;
 */
interface UserRepository extends RepositoryInterface
{
    public function getUserById($id);
}
