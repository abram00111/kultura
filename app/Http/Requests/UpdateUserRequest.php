<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth("web")->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'surname' => ['required', 'string', 'max:255', 'min:2', 'alpha'],
            'name' => ['required', 'string', 'max:255', 'min:2', 'alpha'],
            'patronymic' => ['max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.Auth::user()->id],
            'login' => ['required', 'string', 'max:255', 'unique:users,login,'.Auth::user()->id],
            'school_id' => ['required'],
            'class' => ['required'],
            'class_bukva' => ['required'],
        ];
    }
}
