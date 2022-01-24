@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Регистрация') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="fio" class="col-md-4 col-form-label text-md-end">{{ __('ФИО') }}</label>

                                <div class="col-md-6">
                                    <input id="fio" type="text" class="form-control @error('fio') is-invalid @enderror"
                                           name="fio" value="{{ old('fio') }}" required autocomplete="fio"
                                           placeholder="Иванов Иван Иванович" autofocus>

                                    @error('fio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-end">{{ __('E-Mail') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required placeholder="ivanov@mail.ru"
                                           autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Школа') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select @error('school_id') is-invalid @enderror"
                                            aria-label="Default select example" name="school_id"
                                            value="{{ old('school_id') }}" required>
                                        <option value="1">Open this select menu</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                    @error('school_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Класс') }}</label>
                                <div class="col-md-3">
                                    <select class="form-select"
                                            aria-label="Default select example" name="class"
                                            value="{{ old('class') }}" >
                                        <option value="1" selected>1</option>
                                        @for($i=2; $i<=11; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <label for="email" class="col-md-1 col-form-label text-md-end">{{ __('Буква') }}</label>
                                <div class="col-md-2">
                                    <select class="form-select"
                                            aria-label="Default select example" name="class_bukva"
                                            value="{{ old('class_bukva') }}" >
                                        <option value="А" selected>А</option>
                                        <option value="Б">Б</option>
                                        <option value="В">В</option>
                                        <option value="Г">Г</option>
                                        <option value="Д">Д</option>
                                        <option value="Е">Е</option>
                                        <option value="Ё">Ё</option>
                                        <option value="Ж">Ж</option>
                                        <option value="З">З</option>
                                        <option value="И">И</option>
                                        <option value="К">К</option>
                                        <option value="Л">Л</option>
                                        <option value="М">М</option>
                                        <option value="Н">Н</option>
                                        <option value="О">О</option>
                                        <option value="П">П</option>
                                        <option value="Р">Р</option>
                                        <option value="С">С</option>
                                        <option value="Т">Т</option>
                                        <option value="У">У</option>
                                        <option value="Ф">Ф</option>
                                        <option value="Х">Х</option>
                                        <option value="Ц">Ц</option>
                                        <option value="Ч">Ч</option>
                                        <option value="Ш">Ш</option>
                                        <option value="Ы">Ы</option>
                                        <option value="Э">Э</option>
                                        <option value="Ю">Ю</option>
                                        <option value="Я">Я</option>
                                    </select>
                                </div>

                            </div>


                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Пароль') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Подтвердите пароль') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Регистрация') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
