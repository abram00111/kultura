@extends('layouts.admin')
@section('title')
    Личные данные
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper pt-2">

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="card card-warning">
                    <!-- /.card-header -->
                    @if (session('anchorPassword'))
                        <a name="{{ session('anchorPassword') }}" class="anchor"></a>
                    @endif
                    <div class="card-body">
                        <h4>Сменить пароль</h4>
                        @if (session('statusPassword'))
                            <div class="alert alert-success" role="alert">
                                {{ session('statusPassword') }}
                            </div>
                        @endif
                        <form action="{{route('passwordReset')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Пароль</label>
                                        <input type="password" class="form-control" name="password"
                                               required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Повторите пароль</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                               required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Сменить пароль</button>
                        </form>
                    </div>
                </div>
                <div class="card card-warning">
                    <!-- /.card-header -->
                    @if (session('anchorUser'))
                        <a name="{{ session('anchorUser') }}" class="anchor"></a>
                    @endif
                    <div class="card-body">
                        <h4>Личные данные</h4>
                        @if (session('statusUser'))
                            <div class="alert alert-success" role="alert">
                                {{ session('statusUser') }}
                            </div>
                        @endif
                        <form action="{{route('userInfo')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Фамилия</label>
                                        <input type="text" class="form-control @error('surname')is-invalid @enderror" name="surname" value="{{ (old('surname')!='')?old('surname'):$fio[0] }}"
                                               required autocomplete="off">
                                        @error('surname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Имя</label>
                                        <input type="text" class="form-control @error('name')is-invalid @enderror" name="name" value="{{ (old('name')!='')?old('name'):$fio[1] }}"
                                               required autocomplete="off">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Отчество</label>
                                        <input type="text" class="form-control @error('patronymic')is-invalid @enderror" name="patronymic" value="{{ (old('patronymic')!='')?old('patronymic'):$fio[2] }}"
                                               autocomplete="off">
                                        @error('patronymic')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Дата рождения</label>
                                        <input type="date" class="form-control @error('dob')is-invalid @enderror" name="dob"
                                               value="{{ (old('dob')!='')?old('dob'):\Illuminate\Support\Facades\Auth::user()->dob }}"
                                               autocomplete="off">
                                        @error('dob')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Логин</label>
                                        <input type="text" class="form-control @error('login')is-invalid @enderror" name="login"
                                               value="{{ (old('login')!='')?old('login'):\Illuminate\Support\Facades\Auth::user()->login }}"
                                               autocomplete="off" required>
                                        @error('login')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control @error('email')is-invalid @enderror" name="email"
                                               value="{{ (old('email')!='')?old('email'):\Illuminate\Support\Facades\Auth::user()->email }}"
                                               autocomplete="off" required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5">
                                    <!-- select -->
                                    <div class="form-group">
                                        <label>Школа</label>
                                        <select class="form-control @error('school_id')is-invalid @enderror"
                                                aria-label="Default select example" name="school_id"
                                                required>
                                            <option value="1" selected>option 1</option>
                                        </select>
                                        @error('school_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Класс</label>
                                        <select class="form-control @error('class')is-invalid @enderror"
                                                aria-label="Default select example" name="class"
                                                required>
                                            @for($i=1; $i<=11; $i++)
                                                <option value="{{$i}}" <?php if(old('class')!=''){if(old('class') == $i){ echo 'selected';}}else{if(\Illuminate\Support\Facades\Auth::user()->class_bukva == $i){echo'selected';}}?>>{{$i}}</option>
                                            @endfor
                                        </select>
                                        @error('class')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Буква</label>
                                        <select class="form-control @error('class_bukva')is-invalid @enderror"
                                                aria-label="Default select example" name="class_bukva"
                                                 required>
                                            @foreach(range(chr(0xC0), chr(0xDF)) AS $letter)
                                                <option value="{{ iconv('CP1251', 'UTF-8', $letter) }}" <?php if(old('class_bukva')!=''){if(old('class_bukva') == iconv('CP1251', 'UTF-8', $letter)){ echo 'selected';}}else{if(\Illuminate\Support\Facades\Auth::user()->class_bukva == iconv('CP1251', 'UTF-8', $letter)){echo'selected';}}?>>{{ iconv('CP1251', 'UTF-8', $letter) }}</option>
                                            @endforeach
                                        </select>
                                        @error('class_bukva')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary">Сохранить</button>
                        </form>

                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card card-warning">
                    <!-- /.card-header -->
                    @if (session('anchorImg'))
                        <a name="{{ session('anchorImg') }}" class="anchor"></a>
                    @endif
                    <div class="card-body">
                        <h4>Аватар</h4>
                        @if (session('statusImg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('statusImg') }}
                            </div>
                        @endif
                        <form action="{{route('editAvatar')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <!-- <label for="customFile">Custom File</label> -->
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Загрузить фотографию</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-danger">Удалить фотографию</button>
                                        <button type="submit" class="btn btn-primary">Сохранить</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>


            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
