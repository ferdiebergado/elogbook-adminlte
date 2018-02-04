<?php

namespace Modules\Documents\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
// use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Documents\Repositories\DocumentRepository;
use Modules\Documents\Entities\Document;
// use Modules\Documents\Validators\DocumentValidator;

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
            'received_from' => 'like',
            'received_to' => 'like',
            'released_from' => 'like',
            'released_to' => 'like',            
            'persons_concerned' => 'like', 
            'action_taken' => 'like', 
            'received_by' => 'like',
            'released_by' => 'like'  
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
    
}
