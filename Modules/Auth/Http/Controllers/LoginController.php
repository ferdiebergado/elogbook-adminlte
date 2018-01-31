<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Bestmomo\LaravelEmailConfirmation\Traits\AuthenticatesUsers;
use App\Http\Controllers\EncryptionController;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Password from the request.
     *
     * @var string
     */
    protected $password = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth::login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Store the password from the request
        $this->password = $request->password;

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (!$this->checkCredential($request)) {
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }

        $user = $this->guard()->getLastAttempted();
        
        if ($user->confirmed) {
            // If user is confirmed we make the login and delete session information if needed
            $this->attemptLogin($request);
            if ($request->session()->has('user_id')) {
                $request->session()->forget('user_id');
            }
            return $this->sendLoginResponse($request);
        }

        $request->session()->put('user_id', $user->id);

        return back()->with('confirmation-danger', __('confirmation::confirmation.again'));
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        // Decrypt the password from the request
        $request->merge(['password' => EncryptionController::cryptoJsAesDecrypt(config('app.salt'), $this->password)]);
        return $request->only($this->username(), 'password');
    }    

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user->active) {
            auth()->logout();
            $request->session()->invalidate();
            return back()->with('error', 'Your account has been deactivated. Contact the Website Administrator.');
        }
        return redirect()->intended($this->redirectPath());        
    }

}
