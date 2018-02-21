<?php

namespace Modules\Documents\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Documents\Entities\Doctype;

/**
 * Class DoctypeTransformer.
 *
 * @package namespace Modules\Documents\Transformers;
 */
class DoctypeTransformer extends TransformerAbstract
{
    /**
     * Transform the Doctype entity.
     *
     * @param \Modules\Documents\Entities\Doctype $model
     *
     * @return array
     */
    public function transform(Doctype $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
