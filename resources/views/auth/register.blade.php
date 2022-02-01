@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Регистрация') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" accept-charset="UTF-8">
                            @csrf

                            <div class="row mb-3">
                                <label for="surname" class="col-md-4 col-form-label text-md-end">{{ __('Фамилия') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror"
                                           name="surname" value="{{ old('surname') }}" required autocomplete="surname"
                                           placeholder="Иванов" autofocus>

                                    @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Имя') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name') }}" required autocomplete="name"
                                           placeholder="Иван" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="patronymic" class="col-md-4 col-form-label text-md-end">{{ __('Отчество') }}</label>

                                <div class="col-md-6">
                                    <input id="patronymic" type="text" class="form-control @error('patronymic') is-invalid @enderror"
                                           name="patronymic" value="{{ old('patronymic') }}" autocomplete="patronymic"
                                           placeholder="Иванович" autofocus>

                                    @error('patronymic')
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
                                        @for($i=1; $i<=11; $i++)
                                            <option value="{{$i}}" @if(old('class') == $i) selected @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <label for="email" class="col-md-1 col-form-label text-md-end">{{ __('Буква') }}</label>
                                <div class="col-md-2">
                                    <select class="form-select"
                                            aria-label="Default select example" name="class_bukva"
                                            value="{{ old('class_bukva') }}" >
                                        @foreach(range(chr(0xC0), chr(0xDF)) AS $letter)
                                            <option value="{{ iconv('CP1251', 'UTF-8', $letter) }}" <?php if(old('class_bukva') == iconv('CP1251', 'UTF-8', $letter)){ echo 'selected';}?>>{{ iconv('CP1251', 'UTF-8', $letter) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>


                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Пароль') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="off">

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
                                           name="password_confirmation" required autocomplete="off">
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
