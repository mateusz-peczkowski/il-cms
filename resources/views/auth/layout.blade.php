<!DOCTYPE html>
<html>
<head>
    @include('cmsbackend.parts.head')
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img class="logo-img" src="/backend/favicons/favicon-32x32.png" alt=""> {!! config('app.namesystem') !!}
        </div>
        <div class="login-box-body">
            @yield('content')
        </div>
    </div>
<script src="/backend/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="/backend/plugins/bootstrap/bootstrap.min.js"></script>
<script src="/backend/plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
