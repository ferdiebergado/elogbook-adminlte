<?php

namespace Modules\Documents\Http\Helpers;

use Modules\Documents\Entities\Office;

trait OfficeHelper
{
    protected function hasActiveUsers($id)
    {
        $office = Office::whereHas('users', function ($q) {
            $q->where('role', 3)->where('confirmed', 1)->where('active', 1);
        })->where('id', $id)->first(['id']);
        return $office !== null;
    }
}
