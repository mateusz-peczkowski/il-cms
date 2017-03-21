@extends('cmsbackend.layout')

@section('content')
        <div class="row">
            <div class="col-xs-12">
                <ul class="timeline">
                    <li class="time-label">
                        <span class="bg-blue">
                            16.03.2017
                        </span>
                    </li>
                    <li>
                        <i class="fa fa-users bg-blue"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header">{{ __('Użytkownicy') }}</h3>
                            <div class="timeline-body">
                                <p>{{ __('Dodano obsługę użytkowników. Dodawanie, Usuwanie, nadawanie uprawnień') }}</p>
                            </div>
                        </div>
                    </li>
                    <li class="time-label">
                        <span class="bg-blue">
                            13.03.2017
                        </span>
                    </li>
                    <li>
                        <i class="fa fa-trash bg-red"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header">{{ __('Usunięte elementy') }}</h3>
                            <div class="timeline-body">
                                <p>{{ __('Dodano obsługę kosza oraz przywracania z niego elementów lub usuwania na stałe') }}</p>
                            </div>
                        </div>
                    </li>
                    <li class="time-label">
                        <span class="bg-blue">
                            07.03.2017
                        </span>
                    </li>
                    <li>
                        <i class="fa fa-dashboard bg-blue"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header">{{ __('Pulpit nawigacyjny') }}</h3>
                        </div>
                    </li>
                    <li>
                        <i class="fa fa-database bg-orange"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header">{{ __('Baza danych') }}</h3>
                        </div>
                    </li>
                    <li>
                        <i class="fa fa-book bg-green"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header">{{ __('Dziennik zmian') }}</h3>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
@endsection
