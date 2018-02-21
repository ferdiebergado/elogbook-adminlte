<?php

namespace Modules\Users\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Users\Entities\Jobtitle;

/**
 * Class JobtitleTransformer.
 *
 * @package namespace Modules\Users\Transformers;
 */
class JobtitleTransformer extends TransformerAbstract
{
    /**
     * Transform the Jobtitle entity.
     *
     * @param \Modules\Users\Entities\Jobtitle $model
     *
     * @return array
     */
    public function transform(Jobtitle $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
