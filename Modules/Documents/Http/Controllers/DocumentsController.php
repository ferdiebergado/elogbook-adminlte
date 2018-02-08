<?php
namespace Modules\Documents\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Documents\Http\Requests\DocumentCreateRequest;
use Modules\Documents\Http\Requests\DocumentUpdateRequest;
use Modules\Documents\Repositories\DocumentRepository;
use Illuminate\Validation\ValidationException;
use Exception;
/**
 * Class DocumentsController.
 *
 * @package namespace Modules\Documents\Http\Controllers;
 */
class DocumentsController extends Controller
{
    use \Modules\Documents\Http\Helpers\RequestParser;
    /**
     * @var DocumentRepository
     */
    protected $repository;
    /**
     * DocumentsController constructor.
     *
     * @param DocumentRepository $repository
     */
    public function __construct(DocumentRepository $repository)
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
        // $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(app('\Modules\Documents\Http\Helpers\DocumentRequestCriteria'));
        $this->repository->pushCriteria(\Modules\Documents\Criteria\DocumentRelationsCriteria::class);        
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
        $document = $this->repository->makeModel();
        return view('documents::create', compact('document'));
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
        try {
        $date_received = $this->formatDates($request->received_date, $request->received_time);
        $date_released = $this->formatDates($request->released_date, $request->released_time);
            $document = $this->repository->create(array_merge($request->all(), ['date_received' => $date_received, 'date_released' => $date_released]));
            $response = [
                'message' => 'Document created.',
                'data'    => $document,
            ];
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->route('documents.index')->with('message', $response['message']);
        } catch (Exception $e) {            
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->errorBag()
                ]);
            }
            return redirect()->back()->withInput();
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
        $this->repository->pushCriteria(\Modules\Documents\Criteria\DocumentRelationsCriteria::class);          
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
        $date_received = $this->formatDates($request->received_date, $request->received_time);
        $date_released = $this->formatDates($request->released_date, $request->released_time);
            $document = $this->repository->update(array_merge($request->all(), ['date_received' => $date_received, 'date_released' => $date_released]), $id);
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
    private function formatDates($date, $time)
    {
        $formatted = null;
        if (($date) && ($time)) {
            $formatted = (new \Carbon\Carbon($date . ' ' . $time))->toDateTimeString();
        }
        return $formatted;
    }
}
