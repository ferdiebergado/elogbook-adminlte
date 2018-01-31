<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Prettus\Validator\Contracts\ValidatorInterface;
// use Prettus\Validator\Exceptions\ValidatorException;
use Modules\Users\Http\Requests\UserUpdateRequest;
use Modules\Users\Interfaces\UserRepository;
// use Modules\Users\Validators\UserValidator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Exception;

class UsersController extends Controller
{
    use \App\Http\Helpers\PasswordHelper;

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserValidator
     */
    // protected $validator;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        // $this->validator  = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $users = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $users,
            ]);
        }

        return view('users::index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {

        try {

            // $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $user = $this->repository->create($request->all());

            $response = [
                'message' => 'User created.',
                'data'    => $user->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);

        } catch (ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessage()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessage())->withInput();
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
        $user = $this->repository->getUserById($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $user,
            ]);
        }

        return view('users::show', compact('user'));
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

        $user = $this->repository->getUserById($id);

        return view('users::edit', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        try {

            // $this->validator->with($values)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $values = $this->decryptPassword($request->all());
            
            $user = $this->repository->update($values, $id);

            Cache::forget('user_{$id}');

            $message = 'User updated.';

            $response = [
                'message' => $message,
                'data'    => $user,
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with(compact('message'));

        } catch (Exception $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessage()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessage())->withInput();
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
                'message' => 'User deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'User deleted.');
    }

    /**
     * Update the user avatar in storage.
     *
     * @param  UserUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function avatar(UserUpdateRequest $request, $id)
    {
        try {

            // $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);        

            $file = request()->file('avatar')->store('avatars', 'public');

            Storage::disk('avatars')->delete(request()->user()->avatar);

            $filename = str_replace('avatars/', '', $file);

            $user = $this->repository->update(['avatar' => $filename], $id);       

            Cache::forget('user_{$id}');

            $message = 'Avatar changed.';

            if (request()->wantsJson()) {

                return response()->json([
                    'message' => $message,
                    'user' => $user,
                ]);
            }

            return redirect()->back()->with(compact('message'));

        } catch (Exception $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessage()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessage())->withInput();        
        }
    }

}
