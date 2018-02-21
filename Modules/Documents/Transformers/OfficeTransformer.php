<?php

namespace Modules\Documents\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Documents\Entities\Office;

/**
 * Class OfficeTransformer.
 *
 * @package namespace Modules\Documents\Transformers;
 */
class OfficeTransformer extends TransformerAbstract
{
    /**
     * Transform the Office entity.
     *
     * @param \Modules\Documents\Entities\Office $model
     *
     * @return array
     */
    public function transform(Office $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
