<?php

namespace Modules\Documents\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OfficeCreateRequest;
use App\Http\Requests\OfficeUpdateRequest;
use Modules\Documents\Repositories\OfficeRepository;
use Illuminate\Validation\ValidationException;
use Exception;
/**
 * Class OfficesController.
 *
 * @package namespace Modules\Documents\Http\Controllers;
 */
class OfficesController extends Controller
{
    /**
     * @var OfficeRepository
     */
    protected $repository;

    /**
     * OfficesController constructor.
     *
     * @param OfficeRepository $repository
     * @param OfficeValidator $validator
     */
    public function __construct(OfficeRepository $repository)
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
        $offices = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $offices,
            ]);
        }

        return view('offices.index', compact('offices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OfficeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(OfficeCreateRequest $request)
    {
        try {
            $office = $this->repository->create($request->all());

            $response = [
                'message' => 'Office created.',
                'data'    => $office->toArray(),
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
        } catch (Exception $e) {
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
        $office = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $office,
            ]);
        }

        return view('offices.show', compact('office'));
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
        $office = $this->repository->find($id);

        return view('offices.edit', compact('office'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OfficeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(OfficeUpdateRequest $request, $id)
    {
        try {

            $office = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Office updated.',
                'data'    => $office->toArray(),
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
                'message' => 'Office deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Office deleted.');
    }
    public function showActive() {
        $offices = $this->repository->getActive();
        return $offices->map(function($item, $key) {
            return $item['id'];
        });
    }
}
