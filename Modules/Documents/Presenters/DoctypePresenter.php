<?php

namespace Modules\Documents\Presenters;

use Modules\Documents\Transformers\DoctypeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DoctypePresenter.
 *
 * @package namespace Modules\Documents\Presenters;
 */
class DoctypePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DoctypeTransformer();
    }
}
