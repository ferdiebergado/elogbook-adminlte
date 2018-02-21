<?php
namespace Modules\Documents\Repositories;
use Prettus\Repository\Eloquent\BaseRepository;
// use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Documents\Repositories\DocumentRepository;
use Modules\Documents\Entities\Document;
// use Modules\Documents\Validators\DocumentValidator;
// use Prettus\Repository\Contracts\CacheableInterface;
// use Prettus\Repository\Traits\CacheableRepository;
/**
 * Class DocumentRepositoryEloquent.
 *
 * @package namespace Modules\Documents\Repositories;
 */
class DocumentRepositoryEloquent extends BaseRepository implements DocumentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
            'id',
            'doctype.name' => 'like',
            'details' => 'like',
            'persons_concerned' => 'like', 
            'creator.name' => 'like',        
            'editor.name' => 'like'
    ];
    
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Document::class;
    }
    // public function presenter()
    // {
    //     return 'Modules\\Documents\\Presenters\\DocumentPresenter';
    // }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        // $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app('\Modules\Documents\Http\Helpers\DocumentRequestCriteria'));        
    }
}
