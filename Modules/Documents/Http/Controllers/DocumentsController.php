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
use Modules\Documents\Criteria\MultiSortCriteria;

/**
 * Class DocumentsController.
 *
 * @package namespace Modules\Documents\Http\Controllers;
 */
class DocumentsController extends Controller
{
    use \Modules\Documents\Http\Helpers\RequestParser, \App\Http\Helpers\DateHelper;
    // \Modules\Documents\Http\Helpers\TransactionHelper;
    /**
     * @var DocumentRepository
     */
    protected $repository;
    protected $transaction_repository;

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
        $request = app()->make('request');
        $this->validate($request, [
            'length' => [
                'integer',
                \Illuminate\Validation\Rule::in(config('documents.perPageRange'))
            ],
            'sortBy' => 'string|nullable',
            'orderByMulti' => 'string|nullable'
        ]);
        $perPage = $this->getRequestLength($request);
        // $this->pushCriteria(app('\Modules\Documents\Criteria\DocumentRequestCriteria'));
        $this->repository->with(['doctype', 'creator'])->getByOffice(auth()->user()->office_id);
        // Sort fields based on request orderBy (nested sorting)
        $this->repository->pushCriteria(new MultiSortCriteria($request));
        $documents = $this->repository->paginate($perPage);
        // $documents = $this->sortFields($request, $model)->paginate($perPage);
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
        $document = $this->repository->makeModel();
        $transaction = $this->transaction_repository->makeModel();
        $transaction->date = \Carbon\Carbon::now()->addMinute();
        $transaction->pending = 0;
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
            $document = $this->repository->create(array_merge($request->only('doctype_id', 'details', 'persons_concerned', 'additional_info'), ['office_id' => $office_id]));
        } catch (ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->errorBag()
                ]);
            }
            DB::rollback();
            return redirect()->back()->withErrors($e->errorBag())->withInput();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        try {
            $transaction = $this->transaction_repository->store($request, $document->id, $document->doctype_id);
        } catch (ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->errorBag()
                ]);
            }
            DB::rollback();
            return redirect()->back()->withErrors($e->errorBag())->withInput();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        $response = [
            'message' => 'Document' . __('documents::messages.created'),
            'data' => collect($document)->merge($transaction),
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
        $document = $this->repository->with(['doctype', 'creator'])->find($id);
        $transactions = $this->transaction_repository->getByDocument($id)->latest()->simplePaginate(10);
        if (request()->wantsJson()) {
            return response()->json([
                'data' => collect($document)->merge($transactions),
            ]);
        }
        return view('documents::show', compact('document', 'transactions'));
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
                'data' => $document->toArray(),
            ];
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        } catch (ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (Exception $e) {
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
