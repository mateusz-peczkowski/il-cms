@extends('cmsbackend.layout')

@section('content')
        <div class="row">
            <div class="col-xs-12">
                <ul class="timeline">
                    <li class="time-label">
                        <span class="bg-blue">
                            <strong>v2.0.0</strong> <small>(27.04.2017)</small>
                        </span>
                    </li>
                    <li>
                        <i class="fa fa-files-o bg-purple"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="{{ route('pages') }}">{{ __('Strony') }}</a></h3>
                            <div class="timeline-body">
                                <ul>
                                    <li>{{ __('Lista stron') }}</li>
                                    <li>{{ __('Możliwość dodawania i usuwania stron przez rangę developer i wyżej') }}</li>
                                    <li>{{ __('Edycja dla wszystkich rang.') }}</li>
                                    <li>{{ __('Dopinanie opcji, sekcji, galerii.') }}</li>
                                    <li>{{ __('Możliwość tworzenia różnych stron dla różnych języków.') }}</li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <i class="fa fa-edit bg-orange"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="{{ route('forms.definition') }}">{{ __('Formularze') }}</a></h3>
                            <div class="timeline-body">
                                <ul>
                                    <li>{{ __('Lista formularz') }}</li>
                                    <li>{{ __('Możliwość dodawania i usuwania formularzy przez rangę developer i wyżej') }}</li>
                                    <li>{{ __('Możliwość podpinania osobnych kontrolek pod każdy formularz i ich możliwość rozbudowy') }}</li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <i class="fa fa-wrench bg-blue"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="{{ route('options') }}">{{ __('Główne ustawienia') }}</a></h3>
                            <div class="timeline-body">
                                <ul>
                                    <li>{{ __('Lista opcji') }}</li>
                                    <li>{{ __('Możliwość dodawania i usuwania opcji przez rangę developer i wyżej') }}</li>
                                    <li>{{ __('Możliwość podpinania osobnych opcji pod każdą stronę, sekcję') }}</li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <i class="fa fa-language bg-green"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="{{ route('translations') }}">{{ __('Języki') }}</a></h3>
                            <div class="timeline-body">
                                <ul>
                                    <li>{{ __('Lista języków') }}</li>
                                    <li>{{ __('Możliwość dodawania i usuwania języków przez rangę developer i wyżej') }}</li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <i class="fa fa-key bg-purple"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="{{ route('translations') }}">{{ __('Tłumaczenia') }}</a></h3>
                            <div class="timeline-body">
                                <ul>
                                    <li>{{ __('Lista tłumaczeń') }}</li>
                                    <li>{{ __('Możliwość dodawania i usuwania tłumaczenia przez rangę developer i wyżej') }}</li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <i class="fa fa-refresh bg-blue"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="{{ route('redirects') }}">{{ __('Przekierowania') }}</a></h3>
                            <div class="timeline-body">
                                <ul>
                                    <li>{{ __('Lista przekierowań') }}</li>
                                    <li>{{ __('Możliwość dodawania i usuwania przekierowań przez rangę developer i wyżej') }}</li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <i class="fa fa-users bg-navy"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="{{ route('users') }}">{{ __('Użytkownicy') }}</a></h3>
                            <div class="timeline-body">
                                <ul>
                                    <li>{{ __('Lista użytkowników') }}</li>
                                    <li>{{ __('Możliwość edytowania, dezaktywowania oraz usuwania użytkowników przez rangę minimum: administrator') }}</li>
                                    <li>{{ __('Dodawanie użytkowników przez rangę minimum: administrator z uprawnieniami mniejszymi bądź równymi zalogowanemu użytkownikowi') }}</li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <i class="fa fa-trash bg-red"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="{{ route('trash') }}">{{ __('Usunięte elementy') }}</a></h3>
                            <div class="timeline-body">
                                <ul>
                                    <li>{{ __('Możliwość przywracania elementów ze statusem nieaktywne') }}</li>
                                    <li>{{ __('Możliwość usuwania elementów na stałe') }}</li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <i class="fa fa-dashboard bg-blue"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="{{ route('dashboard') }}">{{ __('Pulpit nawigacyjny') }}</a></h3>
                            <div class="timeline-body">
                                <ul>
                                    <li>{{ __('Ilość zarejestrowanych użytkowników') }}</li>
                                    <li>{{ __('Ilość unikalnych wizyt od początku strony') }}</li>
                                    <li>{{ __('Ilość unikalnych wizyt w tym miesiącu') }}</li>
                                    <li>{{ __('Procent wizyt aktualnego miesiąca w skali roku') }}</li>
                                    <li>{{ __('Informacje o profilu') }}:
                                        <ul>
                                            <li>{{ __('Data i godzina rejestracji') }}</li>
                                            <li>{{ __('Poziom dostępu') }}</li>
                                            <li>{{ __('Ostatnie udane i nieudane zalogowanie') }}</li>
                                        </ul>
                                    </li>
                                    <li>{{ __('Edycja własnego profilu') }}
                                        <ul>
                                            <li>{{ __('Możliwość zmiany avatara (wgranie nowego lub zaciągnięcie z gravatara)') }}</li>
                                            <li>{{ __('Zmiana wyświetlanej nazwy (imię i nazwisko)') }}</li>
                                            <li>{{ __('Zmiana adresu email do logowania') }}</li>
                                            <li>{{ __('Zmiana hasła') }}</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <i class="fa fa-folder-open bg-purple"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="{{ route('documentation') }}">{{ __('Dokumentacja') }}</a></h3>
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
