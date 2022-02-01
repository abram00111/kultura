<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

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
        session()->flash('statusPassword', 'Пароль обновлен');
        session()->flash('anchorPassword', 'anchorPassword');
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


        session()->flash('statusUser', 'Данные обновлены');
        session()->flash('anchorUser', 'anchorUser');
        return Redirect::to(url()->previous() . '#anchorUser');
    }
    public function editAvatar(){
        session()->flash('statusImg', 'Аватар изменен');
        session()->flash('anchorImg', 'anchorImg');
        return Redirect::to(url()->previous() . '#anchorImg');
    }
}
