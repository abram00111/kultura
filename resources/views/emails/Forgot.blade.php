<!doctype html>
<html lang="ru">
<head>
    <title>Регистрация</title>
</head>
<body>
<div style="background: #edf2f7; padding: 10px">
    <div style="margin: 0 auto; max-width: 500px; background: #fff; padding: 10px; border-radius: 5px; box-shadow: 5px 8px 15px #9f9e9e">
        <p>Привет <i>{{ $info['fio'] }}</i> вот Ваши данные для входа</p>
        <p><b>Логин:</b> {{ $info['login'] }}</p>
        <p><b>Пароль:</b> {{ $info['password'] }}</p>
        <p style="margin-top: 26px;">Логин, пароль, и другие данные можно сменить в <a href="{{ $info['server'] }}/user">личном кабинете</a></p>
        <p style="text-align: right">С уважением проект "Культура для школ"</p>
    </div>
</div>
</body>
</html>


