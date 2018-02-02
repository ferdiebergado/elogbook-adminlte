<?php

namespace Modules\Documents\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
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
            'doctype_id',
            'details',
            'date_received',
            'received_from',
            'received_to',
            'date_released',
            'released_from',
            'released_to',            
            'persons_concerned', 
            'action_taken', 
            'received_by'  
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
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
