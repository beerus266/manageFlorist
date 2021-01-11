<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cửa hàng Mơ Lê</title>
    <link rel="stylesheet" href=" {{ asset('css/cssLogin.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/AdminLTE-3.1.0-rc/plugins/fontawesome-free/css/all.min.css') }}">
</head>
<body>
    <form class="login-box" method="get" action="{{ route('login.authen')}}">
        <h1>Đăng nhập</h1>
        <div class="textbox">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Tài khoản" name="name" >
        </div>
        <div class="textbox">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Mật khẩu" name="password" >
        </div>
        @if ( $errors->any() )
            <h4><i class="fas fa-times-circle"></i> {{$errors->first()}}</h4>
        @endif
        <input class="btn" type="submit" name="" value="Đăng nhập">
    </form>
</body>
</html>