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
    // public function presenter()
    // {
    //     return 'Modules\\Documents\\Presenters\\TransactionPresenter';
    // }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app('\Modules\Documents\Http\Helpers\DocumentRequestCriteria'));   
    }    
    public function getByOffice($id)
    {
        return $this->model->where('office_id', $id);
    }
    public function getByTask($task)
    {
        if (($task === 'I') || ($task === 'O')) {
            return $this->model->where('task', $task)->where('pending', 0);
        }
        if ($task === 'P') {
            return $this->model->where('pending', 1);
        }        
    }
    public function getByDocument($id)
    {
        return $this->model->where('document_id', $id);
    }
    // public function getByUserOffice($id)
    // {
    //     return $this->model->with(['creator', 'editor'])->whereHas('creator', function($query) use(&$id) {
    //         $query->where('office_id', $id);
    //     })->orWhereHas('editor', function($query) use(&$id) {
    //         $query->where('office_id', $id);
    //     });        
    // }
    public function notPending()
    {
        return $this->model->where('pending', 0);
    }
    public function pending()
    {
        return $this->model->where('pending', 1);
    }    
    public function latest()
    {
        return $this->model->latest('date');
    }
}
