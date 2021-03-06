<?php
namespace Modules\Users\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Users\Http\Requests\UserUpdateRequest;
use Modules\Users\Repositories\UserRepository;
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
    public function __construct(UserRepository $repository)
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
                    'message' => $e->errorBag()
                ]);
            }
            return redirect()->back()->withErrors($e->getMessage())->withInput();
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
        $user = $this->repository->find($id);
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
        $user = $this->repository->find($id);
        return view('users::show', compact('user'));
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
            $values = $this->decryptPassword($request->all());            
            $user = $this->repository->update($values, $id);
            $message = 'User updated.';
            $response = [
                'message' => $message,
                'data'    => $user,
            ];
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->back()->with(compact('message'));
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
    public function avatar(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'avatar' => 'required|file|image|mimes:jpeg,jpg,png|max:512'
            ]);
            // $file = $request->file('avatar')->store('/', 'avatars');
            $file = Storage::disk('avatars')->putFile('/', $request->file('avatar'));
            $avatar = $this->repository->find($id, ['avatar']);
            if (!empty($avatar)) {
                Storage::disk('avatars')->delete($avatar);                
            }
            $user = $this->repository->update(['avatar' => $file], $id);
            // Cache::forget('user_by_id'.$id);
            Cache::forget('avatar_user_'.$id);
            $message = 'Avatar changed.';
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => $message,
                    'user' => $user,
                ]);
            }
            return redirect()->back()->with(compact('message'));
        } catch (ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->errors()
                ]);
            }
            return redirect()->back()->withErrors($e->errors());        
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());     
        }
    }
}
