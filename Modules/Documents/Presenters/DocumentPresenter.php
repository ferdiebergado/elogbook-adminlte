<?php

namespace Modules\Documents\Presenters;

use Modules\Documents\Transformers\DocumentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DocumentPresenter.
 *
 * @package namespace Modules\Documents\Presenters;
 */
class DocumentPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DocumentTransformer();
    }
}
