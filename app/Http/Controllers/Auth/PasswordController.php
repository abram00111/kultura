<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function forgot(Request $request){
        $data = $request->validate([
            'email'=>["required", "email", "string", "exists:users"],
        ]);
        $password = uniqid();
        $user = User::where('email',$request['email'])->first();
        $user->password = Hash::make($password);
        $user->save();

        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        $info = [
            'password' => $password,
            'fio' => $user['fio'],
            'login' => $user['login'],
            'server' => $url,
            'email' => $user['email'],
        ];

        Mail::to($info['email'])->send(new ForgotPassword($info));

        session()->flash('status', 'На Ваш Email "'.$info['email'].'" были отправлены данные для входа');
        return redirect('/login');
    }
}
