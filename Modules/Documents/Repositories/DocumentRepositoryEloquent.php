<?php
namespace Modules\Documents\Repositories;
use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Documents\Repositories\DocumentRepository;
use Modules\Documents\Entities\Document;
/**
 * Class DocumentRepositoryEloquent.
 *
 * @package namespace Modules\Documents\Repositories;
 */
class DocumentRepositoryEloquent extends BaseRepository implements DocumentRepository
{
    use \Modules\Documents\Http\Helpers\RequestParser;
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
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        // $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app('\Modules\Documents\Http\Helpers\DocumentRequestCriteria'));        
    }
    public function getByOffice($id)
    {
        return $this->model->where('office_id', $id);
    }
    public function latest()
    {
        return $this->model->latest();
    }
}
