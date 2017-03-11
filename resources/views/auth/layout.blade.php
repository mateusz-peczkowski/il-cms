<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="apple-touch-icon" sizes="57x57" href="/backend/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/backend/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/backend/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/backend/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/backend/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/backend/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/backend/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/backend/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/backend/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/backend/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/backend/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/backend/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/backend/favicons/favicon-16x16.png">
    <link rel="manifest" href="/backend/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#2196f3">
    <meta name="msapplication-TileImage" content="/backend/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#2196f3">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/backend/css/bootstrap.min.css">
    <link rel="stylesheet" href="/backend/css/AdminLTE.min.css">

    <link rel="stylesheet" href="/backend/plugins/iCheck/blue.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .logo-img {
            margin-top: -12px;
            margin-right: 5px;
        }
    </style>
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
        console.log('%cCreated by: %cJAMPstudio.pl%c -> %chttp://jampstudio.pl','color: #444','background: #2196F3; color: #fff; padding: 4px;','color: #444','color: #009fe3');
    });
</script>
</body>
</html>
