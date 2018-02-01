<?php

namespace Modules\Documents\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DocumentCreateRequest;
use App\Http\Requests\DocumentUpdateRequest;
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
    /**
     * @var DocumentRepository
     */
    protected $repository;

    /**
     * DocumentsController constructor.
     *
     * @param DocumentRepository $repository
     * @param DocumentValidator $validator
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
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $documents = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $documents,
            ]);
        }

        return view('documents::index', compact('documents'));
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

            $document = $this->repository->create($request->all());

            $response = [
                'message' => 'Document created.',
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
