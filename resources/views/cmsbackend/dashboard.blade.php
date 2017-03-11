@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $userscount }}</h3>
                    <p>{{ __('Ilość zarejestrowanych użytkowników') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ Visitor::count() }}</h3>
                    <p>{{ __('Ilość unikalnych wizyt od początku strony') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $visitors }}</h3>
                    <p>{{ __('Ilość unikalnych wizyt w tym miesiącu') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $visitors/Visitor::count()*100 }}<sup style="font-size: 20px">%</sup></h3>
                    <p>{{ __('Procent wizyt z tego miesiąca do pozostałych') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ $current_user->image ? : '/backend/img/blank.jpg' }}" alt="{{ __('Zdjęcie profilu') }}">
                    <h3 class="profile-username text-center">{{ $current_user->name }}</h3>
                    <h5 class="profile-useremail text-center">{{ $current_user->email }}</h5>
                    <br />
                    <p class="text-muted text-center">{{ __('Aby dodadać avatar skorzystaj z przycisku poniżej. Domyślnie do konta zaciągany jest avatar z serwisu Gravatar, jeżeli ten został uzupełniony na dokładnie taki sam adres e-mail jakim logujesz się do systemu JAMPcms2') }}</p>
                    <hr>
                    <p class="text-center">
                        <a href="#" class="btn btn-success">{{ __('Dodaj nowy avatar') }}</a>
                        <a href="#" class="btn btn-info">{{ __('Zmień swoje dane') }}</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('Informacje o Profilu') }}</h3>
                </div>
                <div class="box-body">
                    <strong><i class="fa fa-book margin-r-5"></i> {{ __('Data i godzina rejestracji') }}</strong>
                    <p class="text-muted">{{ $current_user->created_at }}</p>
                    <hr>
                    <strong><i class="fa fa-balance-scale margin-r-5"></i> {{ __('Poziom dostępu') }}</strong>
                    <p class="text-muted">{{ $current_user_role->title }}</p>
                    @if(!$current_user_attempt_success->isEmpty())
                        @if(isset($current_user_attempt_success[1]))
                            <hr>
                            <strong><i class="fa fa-user-plus margin-r-5"></i> {{ __('Ostatnia udana próba zalogowania') }}</strong>
                            <p class="text-muted">{{ isset($current_user_attempt_success[1]) ? $current_user_attempt_success[1]->created_at : false }}</p>
                        @endif
                    @endif
                    @if(!$current_user_attempt_error->isEmpty())
                        <hr>
                        <strong><i class="fa fa-user-times margin-r-5"></i> {{ __('Ostatnia nieudana próba zalogowania') }}</strong>
                        <p class="text-muted">{{ $current_user_attempt_error->first()->created_at }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection