@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
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
        <div class="col-lg-3 col-xs-6">
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
        <div class="col-lg-3 col-xs-6">
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
        <div class="col-lg-3 col-xs-6">
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
@endsection