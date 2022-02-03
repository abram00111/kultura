<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;

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

    use AuthenticatesUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(LoginRequest $request)
    {
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        $this->incrementLoginAttempts($request);

        $user = User::where('email', $request['email'])->count();
        $login = 'email';
        if($user == 0){
            $user = User::where('login', $request['email'])->count();
            $login = 'login';
        }


            if (Auth::attempt([$login=>$request['email'], 'password'=>$request['password']])) {
                // Аутентификация успешна...
                //Если у пользователя статус доступа "Ученик"
                if(Auth::user()->status_id == 1){
                    return redirect()->intended('assess');
                }

                //Если у пользователя статус доступа "Админ"
                if(Auth::user()->status_id == 2){
                    return redirect()->intended('admin');
                }
            }else{
                session()->flash('status', 'Неверная пара Логин\Пароль');
                return redirect('/login');
            }


//        $this->validateLogin($request);
//
//        // If the class is using the ThrottlesLogins trait, we can automatically throttle
//        // the login attempts for this application. We'll key this by the username and
//        // the IP address of the client making these requests into this application.
//        if (method_exists($this, 'hasTooManyLoginAttempts') &&
//            $this->hasTooManyLoginAttempts($request)) {
//            $this->fireLockoutEvent($request);
//
//            return $this->sendLockoutResponse($request);
//        }
//
//        if ($this->attemptLogin($request)) {
//            if ($request->hasSession()) {
//                $request->session()->put('auth.password_confirmed_at', time());
//            }
//
//            return $this->sendLoginResponse($request);
//        }
//
//        // If the login attempt was unsuccessful we will increment the number of attempts
//        // to login and redirect the user back to the login form. Of course, when this
//        // user surpasses their maximum number of attempts they will get locked out.
//        $this->incrementLoginAttempts($request);

//        return $this->sendFailedLoginResponse($request);
    }
}
