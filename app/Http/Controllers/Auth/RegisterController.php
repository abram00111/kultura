<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\RegisterUserEmailJob;
use App\Mail\RegisterForm;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'surname' => ['required', 'string', 'max:255', 'min:2', 'alpha'],
            'name' => ['required', 'string', 'max:255', 'min:2', 'alpha'],
            'patronymic' => ['max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'school_id' => ['required'],
            'class' => ['required'],
            'class_bukva' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if(!function_exists('mb_ucfirst')) {
            function mb_ucfirst($str) {
                $fc = mb_strtoupper(mb_substr($str, 0, 1));
                return $fc . mb_substr($str, 1);
            }
        }

        $data['surname'] = mb_ucfirst($data['surname']);
        $data['name'] = mb_ucfirst($data['name']);
        $data['patronymic'] = mb_ucfirst($data['patronymic']);

        $short_fio = $data['surname'].' '.substr($data['name'],0,2).'. ';
        if($data['patronymic'] !=''){
            $short_fio .= substr($data['patronymic'],0,2).'.';
        }

        $user = User::create([
            'fio' => ucfirst($data['surname']).' '.ucfirst($data['name']).' '.ucfirst($data['patronymic']),
            'short_fio' => $short_fio,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'school_id' => $data['school_id'],
            'class' => $data['class'],
            'class_bukva' => $data['class_bukva'],
        ]);

        $id = $user->id;
        $user = User::find($id);
        $user->login = $id;
        $user->save();

        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        $info = [
            'password' => $data['password'],
            'fio' => $data['surname'].' '.$data['name'].' '.$data['patronymic'],
            'login' => $id,
            'server' => $url,
            'email' => $data['email'],
        ];

//        dispatch(new RegisterUserEmailJob($info));
        Mail::to($info['email'])->send(new RegisterForm($info));


        return($user);
    }
}
