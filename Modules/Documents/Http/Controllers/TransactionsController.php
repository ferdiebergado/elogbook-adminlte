<?php

namespace Modules\Documents\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Modules\Documents\Criteria\ByOfficeCriteria;
use Modules\Documents\Criteria\MultiSortCriteria;
use Modules\Documents\Repositories\DocumentRepository;
use Modules\Documents\Repositories\TransactionRepository;
use Modules\Documents\Criteria\TransactionsByUserCriteria;
use Modules\Documents\Criteria\TransactionsByTaskCriteria;
use Modules\Documents\Criteria\TransactionRelationsCriteria;
use Modules\Documents\Http\Requests\TransactionUpdateRequest;
use Modules\Documents\Http\Requests\TransactionCreateRequest;
use Illuminate\Support\Facades\Cache;
use Modules\Documents\Entities\Attachment;
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
    protected $repository;
    protected $document_repository;

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
        $documents = $this->document_repository->whereHas('transactions', function ($q) {
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
        // $this->repository->pushCriteria(new ByOfficeCriteria(auth()->user()->office_id));
        // $this->repository->pushCriteria(TransactionRelationsCriteria::class);
        $this->repository->with(['document', 'document.doctype', 'target_office'])->getByOffice(auth()->user()->office_id);
        $this->repository->getByTask($task);
        // $this->repository->pushCriteria(new TransactionsByTaskCriteria($task));
        $this->repository->pushCriteria(new MultiSortCriteria($request));
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
        $transaction = $this->repository->with(['document', 'document.doctype'])->findByField('document_id', (int) $request->document_id, ['document_id'])->first();
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
            $transaction = $this->repository->store($request, $request->document_id, $request->transaction_doctype_id);
            $response = [
                'message' => 'Transaction created.',
                'data' => $transaction,
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
                    'error' => true,
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
        $attachments = Attachment::where('transaction_id', $id)->get(['transaction_id', 'filename', 'path', 'url']);
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $transaction,
            ]);
        }
        return view('documents::transactions.show', compact('transaction', 'attachments'));
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
                $request->only('task', 'document_id', 'doctype_id', 'from_to_office', 'action', 'action_to_be_taken', 'by', 'pending'),
                ['date' => $date],
                ['office_id' => $office_id]
            ), $id);
            // Update the parent transaction with the name of the receiver.
            $this->repository->update(['by' => $request->by], $transaction->parent_id);
            $this->addAttachments($id);
            DB::commit();
            $response = [
                'message' => 'Transaction updated.',
                'data' => $transaction,
            ];
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->route('transactions.index')->with('message', $response['message']);
        } catch (ValidationException $e) {
            DB::rollback();
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
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
    public function storeAttachment(Request $request)
    {
        try {    
            $this->validate($request, [
                'attachment' => 'required|file|mimes:jpeg,jpg,png,pdf'
            ]);        
            $dir = (string) auth()->user()->office_id;
            $folders = Cache::remember('folders', now()->addMonth(), function() {
                $contents = collect(Storage::disk(ACTIVE_DISK)->listContents('/', false));
                return $contents->where('type', 'dir'); // directories                
            });
            $base = $folders->where('filename', $dir);
            $folder = $base->first();
            $count = $base->count();
            if ($count === 0) {
                Storage::disk(ACTIVE_DISK)->makeDirectory($dir);
                Cache::forget('folders');
            }
            $file = $request->file('attachment');
            $name = $file->getClientOriginalName();
            // $filename = $file->store($folder['path'], ACTIVE_DISK);
            $filename = Storage::disk(ACTIVE_DISK)->putFile($folder['path'], $file);
            $fileurl = Storage::disk(ACTIVE_DISK)->url($folder['path'] . '/' . $filename);
            $path = explode('/', $filename);
            $filepath = $path[1];
            $attachments = array(['filename' => $name, 'path' => $filepath, 'url' => $fileurl]);
            if (session()->has('attachments')) {
                session()->put('attachments', array_merge(session()->get('attachments'), $attachments));
            } else {
                session()->put('attachments', $attachments);
            }
            $message = 'Attachment successfully uploaded.';
            return compact('fileurl', 'filepath', 'message');
        } catch (ValidationException $e) {
            return ['message' => $e->errors()];        
        } catch (Exception $e) {
            return ['message' => $e->getMessage()];
        }        
    }
    public function removeAttachment(Request $request)
    {
        try {
            $this->validate($request, [
                'path' => 'required|string'
            ]);
            $files = collect(Storage::disk(ACTIVE_DISK)->listContents());
            $dir = $files->where('type', 'dir')->where('filename', auth()->user()->office_id)->first();
            $path = Storage::disk(ACTIVE_DISK)->delete($dir['path']. '/' . $request->path);
            return ['path' => $path];
        } catch(ValidationException $e) {
            return ['message' => $e->errors()];
        } catch (Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }
}
