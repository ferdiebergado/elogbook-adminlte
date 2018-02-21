<?php

namespace Modules\Users\Presenters;

use Modules\Users\Transformers\JobtitleTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class JobtitlePresenter.
 *
 * @package namespace Modules\Users\Presenters;
 */
class JobtitlePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new JobtitleTransformer();
    }
}
