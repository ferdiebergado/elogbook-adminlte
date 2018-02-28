<?php
namespace Modules\Documents\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Documents\Http\Requests\TransactionCreateRequest;
use Modules\Documents\Http\Requests\TransactionUpdateRequest;
use Modules\Documents\Repositories\TransactionRepository;
use Illuminate\Validation\ValidationException;
use Exception;
use Modules\Documents\Criteria\TransactionsByTaskCriteria;
use Modules\Documents\Criteria\TransactionRelationsCriteria;
use Modules\Documents\Criteria\TransactionsByOfficeCriteria;
use Modules\Documents\Criteria\PendingTransactionsCriteria;
use Modules\Documents\Criteria\MultiSortCriteria;
use Modules\Documents\Criteria\TransactionsNotPendingCriteria;
use Modules\Documents\Criteria\TransactionsByUserCriteria;
use Illuminate\Support\Facades\DB;
use Modules\Users\Entities\User;
/**
 * Class TransactionsController.
 *
 * @package namespace Modules\Documents\Http\Controllers;
 */
class TransactionsController extends Controller
{
    use \App\Http\Helpers\DateHelper, \Modules\Documents\Http\Helpers\RequestParser;
    /**
     * @var TransactionRepository
     */
    protected $repository;
    /**
     * TransactionsController constructor.
     *
     * @param TransactionRepository $repository
     */
    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }
    public function home()
    {
        $this->repository->pushCriteria(TransactionRelationsCriteria::class);
        $this->repository->pushCriteria(TransactionsByUserCriteria::class);
        $this->repository->pushCriteria(TransactionsNotPendingCriteria::class);
        $transactions = $this->repository->orderBy('updated_at', 'desc')->paginate(10);
        return view('documents::home', compact('transactions'));        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(TransactionsByOfficeCriteria::class);
        $this->repository->pushCriteria(TransactionRelationsCriteria::class);
        $this->repository->pushCriteria(MultiSortCriteria::class);
        $request = app()->make('request');
        $task = $request->task;
        if (($task === 'I') || ($task === 'O')) {
            $this->repository->pushCriteria(new TransactionsByTaskCriteria($task));
        }
        if ($task === 'P') {
            $this->repository->pushCriteria(PendingTransactionsCriteria::class);
        }
        $this->repository->pushCriteria(MultiSortCriteria::class);
        $perPage = $this->getRequestLength($request);    
        $transactions = $this->repository->paginate($perPage);        
        if (request()->wantsJson()) {
            return response()->json([
                'draw' => $request->draw,
                'data' => $transactions
            ]);
        }
        return view('documents::transactions.index', compact('transactions'));
    }
    /**
     * Show the form for releasing a document.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'document_id' => 'required|integer'
        ]);
        $transaction = $this->repository->with('document')->findByField('document_id', (int) $request->document_id, ['document_id'])->first();
        $transaction->pending = 0;
        $release = false;
        return view('documents::transactions.create', compact('transaction', 'release'));
    }      
    /**
     * Store a newly created resource in storage.
     *
     * @param  TransactionCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TransactionCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $date = $this->formatDates($request->task_date, $request->task_time);
            $office_id = auth()->user()->office_id;
            $transaction = $this->repository->create(array_merge(
                $request->only('task', 'document_id', 'from_to_office', 'action', 'action_to_be_taken', 'by', 'pending'), 
                ['date' => $date], 
                ['office_id' => $office_id]
            ));
            // Create a new receive transaction if the destination office has registered users.
            if ($request->task === 'O') {
                $office = \Modules\Documents\Entities\Office::find($request->from_to_office);
                if ($office->users()->where('name', '<>', null)->count() >= 1) {                    
                    $by = config('documents.PENDING');
                    $user = User::where('name', $transaction->by)->value('name');
                    if (!empty($user)) {
                        $by = $user;
                    }
                    $received = [
                        'task'              =>  'I',
                        'document_id'       =>  $transaction->document_id,
                        'from_to_office'    =>  $office_id,
                        'date'              =>  $transaction->date->addMinute(),
                        'action'            =>  config('documents.PENDING'),
                        'action_to_be_taken' => $transaction->action_to_be_taken,
                        'by'                =>  $by,
                        'office_id'         =>  $transaction->from_to_office,
                        'pending'           =>  1
                    ];
                    $this->repository->create($received);
                }
            }
            $response = [
                'message' => 'Transaction created.',
                'data'    => $transaction,
            ];
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            DB::commit();
            return redirect()->route('transactions.index')->with('message', $response['message']);
        } catch (ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->errorBag()
                ]);
            }
            DB::rollback();
            return redirect()->back()->withErrors($e->errorBag())->withInput();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
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
        $this->repository->pushCriteria(TransactionRelationsCriteria::class);        
        $transaction = $this->repository->find($id);        
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $transaction,
            ]);
        }
        return view('documents::transactions.show', compact('transaction'));
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
        $transaction = $this->repository->find($id);
        return view('documents::transactions.edit', compact('transaction'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  TransactionUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws ValidationException, Exception
     */
    public function update(TransactionUpdateRequest $request, $id)
    {
        try {
            $date = $this->formatDates($request->task_date, $request->task_time);
            $office_id = auth()->user()->office_id;
            $transaction = $this->repository->update(array_merge($request->only('task', 'document_id', 'from_to_office', 'action', 'action_to_be_taken', 'by', 'pending'), ['date' => $date], ['office_id' => $office_id]), $id);            
            $response = [
                'message' => 'Transaction updated.',
                'data'    => $transaction,
            ];
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        } catch (ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->errorBag()
                ]);
            }
            return redirect()->back()->withErrors($e->errorBag())->withInput();
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
                'message' => 'Transaction deleted.',
                'deleted' => $deleted,
            ]);
        }
        return redirect()->back()->with('message', 'Transaction deleted.');
    }
    /**
     * Show the form for receiving a document.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function receive($id)
    {
        $transaction = $this->repository->find($id);
        $transaction->pending = 0;             
        return view('documents::transactions.edit', compact('transaction'));
    }    
    /**
     * Show the form for releasing a document.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function release($id)
    {
        $transaction = $this->repository->find($id);
        $transaction->task = 'O';   
        $transaction->from_to_office = 0;
        $transaction->date = \Carbon\Carbon::now();
        $transaction->action = '';
        $transaction->action_to_be_taken = '';
        $transaction->by = auth()->user()->name;
        $transaction->pending = 0;
        return view('documents::transactions.create', compact('transaction'));
    }      
}
