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
                    <i class="ion ion-stats-bars"></i>
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
                    <i class="ion ion-arrow-graph-up-right"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $visitors/$visitorsYear*100 }}<sup style="font-size: 20px">%</sup></h3>
                    <p>{{ __('Procent wizyt aktualnego miesiąca w skali roku') }}</p>
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
                    @if(Session::has('status'))
                        <div class="alert alert-success alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    <img class="profile-user-img img-responsive img-circle" src="{{ $current_user->image ? : '/backend/img/blank.jpg' }}" alt="{{ __('Zdjęcie profilu') }}">
                    <h3 class="profile-username text-center">{{ $current_user->name }}</h3>
                    <h5 class="profile-useremail text-center">{{ $current_user->email }}</h5>
                    <br />
                    <p class="text-muted text-center">{{ __('Aby dodadać avatar skorzystaj z przycisku poniżej. Domyślnie do konta zaciągany jest avatar z serwisu Gravatar, jeżeli ten został uzupełniony na dokładnie taki sam adres e-mail jakim logujesz się do systemu JAMPcms2') }}</p>
                    <hr>
                    <p class="text-center clearfix">
                        <span data-toggle="modal" data-target="#userAvatarModal" class="btn btn-success pull-left">{{ __('Dodaj/zmień zdjęcie profilowe') }}</span>
                        <span data-toggle="modal" data-target="#userEditModal" class="btn btn-info pull-right">{{ __('Zmień swoje dane') }}</span>
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
                    <strong><i class="fa fa-book margin-r-5"></i> {{ __('Data i godzina Twojej rejestracji w systemie (Czas UTC)') }}</strong>
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

@section('modals')
    <div class="modal fade" id="userEditModal" tabindex="-1" role="dialog" aria-labelledby="userEditModalLabel">
        <div class="modal-dialog" role="document">
            <form role="form" method="POST" action="{{ route('user.editcurrent') }}" class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">{{ __('Jakie dane zmieniamy?') }}</h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>{{ __('Imię i nazwisko') }}</label>
                        <input type="text" id="name" name="user_name" class="form-control" value="{{ $current_user->name }}" required />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Adres e-mail') }} {{ __('(służy do logowania)') }}</label>
                        <input type="text" id="email" name="user_email" class="form-control" value="{{ $current_user->email }}" required />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Hasło') }} {{ __('(wypełnić wyłącznie w przypadku zmiany)') }}</label>
                        <input type="password" id="password" name="user_password" class="form-control" value="{{ old('password') }}" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger pull-left">{{ __('Wyczyść zmiany') }}</button>
                    <button type="submit" class="btn btn-success pull-right">{{ __('Zapisz zmiany') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="userAvatarModal" tabindex="-1" role="dialog" aria-labelledby="userAvatarModalLabel">
        <div class="modal-dialog" role="document">
            {{Form::open(['route' => 'user.addavatar', 'files' => true, 'method' => 'POST', 'class' => 'modal-content'])}}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">{{ __('Skąd chcesz dodać zdjęcie profilowe?') }}</h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>{{ __('Z dysku') }}</label>
                        <input type="file" id="photo" name="photo" />
                    </div>
                    <p>{{ __('Lub') }}</p>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="photo_gravatar" name="photo_gravatar"> {{ __('Pobierz z Gravatara') }}
                        </label>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success pull-right">{{ __('Dodaj/zmień zdjęcie') }}</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
@endsection