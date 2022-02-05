<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\UserUpdate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function index(){
        return view('admin.adminPanel');
    }

    public function user(){
        return view('admin.user',[
            'fio'=>explode(' ',Auth::user()->fio)
        ]);
    }

    public function passwordReset(UpdatePasswordRequest $request){
        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request['password']);
        $user->save();
        session()->flash('statusPassword', 'Пароль обновлен');
        session()->flash('anchorPassword', 'anchorPassword');

        //Отправим сообщение на email
        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        $info = [
            'password' => $request['password'],
            'fio' => $user->fio,
            'login' => $user->login,
            'server' => $url,
            'email' => $user->email,
        ];
        Mail::to($info['email'])->send(new UserUpdate($info));

        return Redirect::to(url()->previous() . '#anchorPassword');
    }
    public function userInfo(UpdateUserRequest $data){

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

        $user = User::find(Auth::user()->id);
        $user->fio = ucfirst($data['surname']).' '.ucfirst($data['name']).' '.ucfirst($data['patronymic']);
        $user->short_fio = $short_fio;
        $user->email = $data['email'];
        $user->login = $data['login'];
        $user->school_id = $data['school_id'];
        $user->dob = $data['dob'];
        $user->class = $data['class'];
        $user->class_bukva = $data['class_bukva'];
        $user->save();

        session()->flash('statusUser', 'Данные обновлены');
        session()->flash('anchorUser', 'anchorUser');

        return Redirect::to(url()->previous() . '#anchorUser');
    }

    public function editAvatar(UpdateAvatarRequest $request){
        if($request->hasFile('avatar')){
            $image = $request->file('avatar');
            $filename = Auth::id(). '.'. $image->getClientOriginalExtension();
            $path = $image->move(Storage::path('/public/img/avatar/').'origin/',$filename);;

            $mini = Image::make(Storage::path('/public/img/avatar/').'origin/'.$filename);
            $mini->fit(100, 100);
            $mini->save(Storage::path('/public/img/avatar/').'mini/'.$filename);

            $user = User::find(Auth::id());
            $user->avatar = $filename;
            $user->save();
            session()->flash('statusImg', 'Аватар изменен');
        }else{
            $user = User::find(Auth::id());
            $user->avatar = 'user.jpg';
            $user->save();
            session()->flash('statusImg', 'Аватар удален');
        }
        session()->flash('anchorImg', 'anchorImg');
        return Redirect::to(url()->previous() . '#anchorImg');
    }

    public function school(){
        return view('school');
    }
}
