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
        // try {

            $document = $this->repository->create($request->all());

            $response = [
                'message' => 'Document created.',
                'data'    => $document,
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);

        // } catch (ValidationException $e) {
            
        //     if ($request->wantsJson()) {
        //         return response()->json([
        //             'error'   => true,
        //             'message' => $e->errorBag()
        //         ]);
        //     }

        //     return redirect()->back()->withInput();

        // } catch (Exception $e) {
            
        //     if ($request->wantsJson()) {
        //         return response()->json([
        //             'error'   => true,
        //             'message' => $e->getMessage()
        //         ]);
        //     }

        //     return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        // }        
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
