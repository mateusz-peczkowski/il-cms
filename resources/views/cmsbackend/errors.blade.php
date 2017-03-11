<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/css/skin-blue-light.min.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .error-page {
            margin-top: 150px;
        }
        .error-page .headline {
            margin-top: -5px;
        }
        .error-page .btn {
            margin-top: 15px;
        }
    </style>
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-red"> {{ $exception }}</h2>

            <div class="error-content">
                <h3>{{ __('Wystąpił błąd') }}</h3>

                <p>{{ __('Aby powrócić do panelu kliknij link poniżej') }}</p>

                <a href="{{ route('dashboard') }}" class="btn btn-info" title="{{ __('Powrót do panelu') }}">{{ __('Powrót do panelu') }}</a>
            </div>
        </div>
    </section>
</div>
</body>
</html>
