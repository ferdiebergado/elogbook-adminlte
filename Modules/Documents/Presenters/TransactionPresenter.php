<?php

namespace Modules\Documents\Presenters;

use Modules\Documents\Transformers\TransactionTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TransactionPresenter.
 *
 * @package namespace Modules\Documents\Presenters;
 */
class TransactionPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TransactionTransformer();
    }
}
