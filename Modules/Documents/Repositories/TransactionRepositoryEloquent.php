<?php
namespace Modules\Documents\Repositories;
use Prettus\Repository\Eloquent\BaseRepository;
// use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Documents\Repositories\TransactionRepository;
use Modules\Documents\Entities\Transaction;
/**
 * Class TransactionRepositoryEloquent.
 *
 * @package namespace Modules\Documents\Repositories;
 */
class TransactionRepositoryEloquent extends BaseRepository implements TransactionRepository
{
        /**
     * @var array
     */
    protected $fieldSearchable = [
            'id',
            'document.id',
            'document.doctype.name' => 'like',
            'document.details' => 'like',
            'document.persons_concerned' => 'like',
            'target_office.name' => 'like',
            'action' => 'like',
            'by' => 'like'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Transaction::class;
    }
    
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app('\Modules\Documents\Http\Helpers\DocumentRequestCriteria'));   
    }    
}
