<?php
namespace Modules\Documents\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Documents\Http\Requests\TransactionCreateRequest;
use Modules\Documents\Http\Requests\TransactionUpdateRequest;
use Modules\Documents\Repositories\TransactionRepository;
use Modules\Documents\Repositories\DocumentRepository;
use Illuminate\Validation\ValidationException;
use Exception;
use Modules\Documents\Criteria\TransactionsByTaskCriteria;
use Modules\Documents\Criteria\TransactionRelationsCriteria;
use Modules\Documents\Criteria\TransactionsByOfficeCriteria;
use Modules\Documents\Criteria\PendingTransactionsCriteria;
use Modules\Documents\Criteria\MultiSortCriteria;
use Modules\Documents\Criteria\TransactionsNotPendingCriteria;
use Modules\Documents\Criteria\TransactionsByUserCriteria;
use Modules\Documents\Criteria\ByOfficeCriteria;
use Illuminate\Support\Facades\DB;
use Modules\Users\Entities\User;
use Carbon\Carbon;
/**
 * Class TransactionsController.
 *
 * @package namespace Modules\Documents\Http\Controllers;
 */
class TransactionsController extends Controller
{
    use \App\Http\Helpers\DateHelper, \Modules\Documents\Http\Helpers\RequestParser;
    // \Modules\Documents\Http\Helpers\TransactionHelper;
    /**
     * @var TransactionRepository
     */
    protected $repository, $document_repository;
    /**
     * TransactionsController constructor.
     *
     * @param TransactionRepository $repository
     */
    public function __construct(TransactionRepository $repository, DocumentRepository $document_repository)
    {
        $this->repository = $repository;
        $this->document_repository = $document_repository;
    }
    public function home()
    {
        $documents = $this->document_repository->whereHas('transactions', function($q) {
            $q->where('office_id', auth()->user()->office_id);
        })->all(['id']);
        $this->repository->pushCriteria(TransactionsByUserCriteria::class);
        $transactions = $this->repository->with('document', function ($q) use ($documents) {
            $list = $documents->pluck('id')->toArray();
            if ($documents->count() > 1) {
                $list = implode(',', $list);
                $q->whereIn('id', [$list]);
            } else {
                $q->where('id', (int) $list[0]);
            }
        })->notPending()->latest()->simplePaginate(5);
        return view('documents::home', compact('transactions'));        
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->repository->pushCriteria(app('\Modules\Documents\Criteria\DocumentRequestCriteria'));   
        $request = app()->make('request');
        $this->validate($request, [
            'task' => \Illuminate\Validation\Rule::in(config('documents.tasks'))
        ]);
        $task = $request->task;
        // $this->repository->pushCriteria(TransactionRelationsCriteria::class);
        // $this->repository->pushCriteria(new ByOfficeCriteria(auth()->user()->office_id));
        $this->repository->pushCriteria(new TransactionsByTaskCriteria($task));
        $model = $this->repository->with(['document', 'document.doctype', 'target_office'])->getByOffice(auth()->user()->office_id);
        // dd($this->repository->all());
        $perPage = $this->getRequestLength($request);    
        $transactions = $this->repository->paginate($perPage);
        // $transactions = $this->sortFields($request, $this->repository)->paginate($perPage);        
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
        $transaction->date = Carbon::now()->addMinute();
        $transaction->pending = 0;
        return view('documents::transactions.create', compact('transaction'));
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
            $transaction = $this->repository->store($request, $request->document_id);
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
            DB::rollback();
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->errorBag()
                ]);
            }
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
        $transaction = $this->repository->with(['document', 'document.doctype', 'target_office'])->find($id);        
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
        DB::beginTransaction();
        try {
            $date = $this->formatDates($request->task_date, $request->task_time);
            $office_id = auth()->user()->office_id;
            $transaction = $this->repository->update(array_merge(
                $request->only('task', 'document_id', 'from_to_office', 'action', 'action_to_be_taken', 'by', 'pending'), 
                ['date' => $date], 
                ['office_id' => $office_id]
            ), $id);            
            // Update the parent transaction with the name of the receiver.
            $this->repository->update(['by' => $request->by], $transaction->parent_id);
            DB::commit();
            $response = [
                'message' => 'Transaction updated.',
                'data'    => $transaction,
            ];
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->route('transactions.index')->with('message', $response['message']);
        } catch (ValidationException $e) {
            DB::rollback();
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->errorBag()
                ]);
            }
            return redirect()->back()->withErrors($e->errorBag())->withInput();
        } catch(Exception $e) {
            DB::rollback();
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
        $transaction->date = $transaction->date->addMinutes(2);
        $transaction->by = auth()->user()->name;        
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
        $transaction->date = Carbon::now();
        $transaction->action = '';
        $transaction->action_to_be_taken = '';
        $transaction->pending = 0;
        return view('documents::transactions.create', compact('transaction'));
    }      
}
