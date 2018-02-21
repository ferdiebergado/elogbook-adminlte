<?php

namespace Modules\Documents\Presenters;

use Modules\Documents\Transformers\OfficeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OfficePresenter.
 *
 * @package namespace Modules\Documents\Presenters;
 */
class OfficePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OfficeTransformer();
    }
}
