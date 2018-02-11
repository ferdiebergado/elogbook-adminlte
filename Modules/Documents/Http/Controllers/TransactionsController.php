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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(TransactionsByOfficeCriteria::class);
        $this->repository->pushCriteria(TransactionRelationsCriteria::class);
        $request = app()->make('request');
        $task = $request->task;
        if (($task === 'I') || ($task === 'O')) {
            $this->repository->pushCriteria(new TransactionsByTaskCriteria($task));
        }
        $perPage = $this->getRequestLength($request);    
        $transactions = $this->repository->paginate($perPage);        
        if (request()->wantsJson()) {
            return response()->json([
                'draw' => $request->draw,
                'data' => $transactions,
            ]);
        }
        return view('documents::transactions.index', compact('transactions'));
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
        try {
            $transaction = $this->repository->create($request->all());
            $response = [
                'message' => 'Transaction created.',
                'data'    => $transaction->toArray(),
            ];
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
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
        // $this->repository->pushCriteria(app('\Modules\Documents\Http\Helpers\DocumentRequestCriteria'));
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
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TransactionUpdateRequest $request, $id)
    {
        try {
            $date = $this->formatDates($request->task_date, $request->task_time);
            $office_id = auth()->user()->office_id;            
            $transaction = $this->repository->update(array_merge($request->only('task', 'document_id', 'from_to_office', 'by'), ['date' => $date], ['office_id' => $office_id]), $id);            
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
}
