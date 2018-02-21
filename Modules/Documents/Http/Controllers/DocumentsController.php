<?php
namespace Modules\Documents\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Documents\Http\Requests\DocumentCreateRequest;
use Modules\Documents\Http\Requests\DocumentUpdateRequest;
use Modules\Documents\Repositories\DocumentRepository;
use Modules\Documents\Repositories\TransactionRepository;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Documents\Criteria\DocumentRelationsCriteria;
use Modules\Documents\Criteria\DocumentsByOfficeCriteria;
use Modules\Documents\Criteria\MultiSortCriteria;
use Modules\Documents\Entities\Office;
/**
 * Class DocumentsController.
 *
 * @package namespace Modules\Documents\Http\Controllers;
 */
class DocumentsController extends Controller
{    
    use \Modules\Documents\Http\Helpers\RequestParser, \App\Http\Helpers\DateHelper;
    /**
     * @var DocumentRepository
     */
    protected $repository, $transaction_repository;
    /**
     * DocumentsController constructor.
     *
     * @param DocumentRepository $repository
     */
    public function __construct(DocumentRepository $repository, TransactionRepository $transaction_repository)
    {
        $this->repository = $repository;
        $this->transaction_repository = $transaction_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(DocumentsByOfficeCriteria::class);
        $this->repository->pushCriteria(DocumentRelationsCriteria::class);        
        $this->repository->pushCriteria(MultiSortCriteria::class);
        $request = app()->make('request');
        $perPage = $this->getRequestLength($request);    
        $documents = $this->repository->paginate($perPage);
        if (request()->wantsJson()) {
            return response()->json([
                'draw' => $request->draw,
                'data' => $documents,
            ]);
        }
        return view('documents::index', compact('documents'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->repository->pushCriteria(DocumentRelationsCriteria::class);        
        $document = $this->repository->makeModel();
        $transaction = $this->transaction_repository->makeModel();
        return view('documents::create', compact('document', 'transaction'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  DocumentCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(DocumentCreateRequest $request)
    {
        $date = $this->formatDates($request->task_date, $request->task_time);
        $office_id = auth()->user()->office_id;
        DB::beginTransaction();
        try {
            $document = $this->repository->firstOrCreate(array_merge($request->only('doctype_id', 'details', 'persons_concerned'), ['office_id' => $office_id]));
        } catch(ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->errorBag()
                ]);
            }
            DB::rollback();
            return redirect()->back()->withErrors($e->errorBag())->withInput();
        } catch(Exception $e) {
            DB::rollback();
            throw $e;            
        }
        try {
            $transaction = $this->transaction_repository->firstOrCreate(array_merge(
                $request->only('task', 'from_to_office', 'action', 'action_to_be_taken', 'by'), 
                ['document_id' => $document->id], 
                ['date' => $date], 
                ['office_id' => $office_id]
            ));
            if ($request->task === 'O') {                
                if (Office::find($request->from_to_office)->has('users')) {
                    switch ($request->task) {
                        case 'I':
                        $task = 'O';
                        break;
                        case 'O':
                        $task = 'I';
                        break;
                    }
                    $from_to_office = auth()->user()->office_id;
                    $office_id = $request->from_to_office;
                    $action = config('documents.PENDING');
                    $by = config('documents.PENDING');
                    $transaction = $this->transaction_repository->firstOrCreate(array_merge(
                        ['task' => $task], 
                        ['document_id' => $document->id], 
                        ['from_to_office' => $from_to_office], 
                        ['date' => $date], 
                        ['action' => $action], 
                        $request->only('action_to_be_taken'),
                        ['by' => $by], 
                        ['office_id' => $office_id], 
                        ['pending' => 1]
                    ));
                }
            }
        } catch(ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->errorBag()
                ]);
            }
            DB::rollback();
            return redirect()->back()->withErrors($e->errorBag())->withInput();
        } catch(Exception $e) {
            DB::rollback();
            throw $e;
        }
        $response = [
            'message' => 'Document created.',
            'data'    => collect($document)->merge($transaction),
        ];
        if ($request->wantsJson()) {
            return response()->json($response);
        }
        DB::commit();
        return redirect()->route('documents.index')->with('message', $response['message']);        
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->repository->pushCriteria(DocumentRelationsCriteria::class);          
        $document = $this->repository->find($id);
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $document,
            ]);
        }
        return view('documents::show', compact('document'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->repository->pushCriteria(DocumentRelationsCriteria::class);
        $document = $this->repository->find($id);        
        return view('documents::edit', compact('document'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  DocumentUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(DocumentUpdateRequest $request, $id)
    {
        try {
            $document = $this->repository->update($request->all(), $id);
            $response = [
                'message' => 'Document updated.',
                'data'    => $document->toArray(),
            ];
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        } catch (ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch(Exception $e) {
            throw $e;
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Document deleted.',
                'deleted' => $deleted,
            ]);
        }
        return redirect()->back()->with('message', 'Document deleted.');
    }
}
