<?php

namespace Modules\Auth\Http\Controllers;

use Modules\Users\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Foundation\Auth\RegistersUsers;
use Bestmomo\LaravelEmailConfirmation\Traits\RegistersUsers;
use Bestmomo\LaravelEmailConfirmation\Notifications\ConfirmEmail;
use App\Http\Controllers\EncryptionController;

class RegisterController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, \App\Http\Helpers\PasswordHelper;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth::register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data = $this->decryptPassword($data);

        return Validator::make($data, [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:150|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $data = $this->decryptPassword($data);
        
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

    /**
     * Notify user with email
     *
     * @param  Model $user
     * @return void
     */
    protected function notifyUser($user)
    {
        $class = 'Modules\\Auth\\Notifications\\ConfirmEmail';

        if (!class_exists($class)) {
            $class = ConfirmEmail::class;
        }

        $user->notify(new $class);
    }

}
