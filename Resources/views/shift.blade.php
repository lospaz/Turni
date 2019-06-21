@extends('layouts.app')

@push('css')
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header">Menù</div>
                <div class="list-group list-group-transparent mb-0">

                    <a href="{{ route('manager.settings.index') }}"
                       class="list-group-item list-group-item-action @if(Route::is('manager.settings.*')) active @endif">
                        <span class="icon mr-3"><i class="fas fa-user-clock"></i></span>Turni
                    </a>

                    <a href="{{ route('shifts.templates.index') }}"
                       class="list-group-item list-group-item-action @if(Route::is('shifts.templates.*')) active @endif">
                        <span class="icon mr-3"><i class="fas fa-shapes"></i></span>Modelli
                    </a>

                    <a href="{{ route('shifts.activities.index') }}"
                       class="list-group-item list-group-item-action @if(Route::is('shifts.activities.*')) active @endif">
                        <span class="icon mr-3"><i class="fa fa-play"></i></span>Attività
                    </a>

                    <a href="{{ route('shifts.tasks.index') }}"
                       class="list-group-item list-group-item-action @if(Route::is('shifts.tasks.*')) active @endif">
                        <span class="icon mr-3"><i class="fa fa-puzzle-piece"></i></span>Mansioni
                    </a>

                    <a href="{{ route('shifts.locals.index') }}"
                       class="list-group-item list-group-item-action @if(Route::is('shifts.locals.*')) active @endif">
                        <span class="icon mr-3"><i class="fa fa-thumbtack"></i></span>Locali
                    </a>
                </div>

            </div>
        </div>
        <div class="col-lg-9">
            @yield('shift.content')
        </div>
    </div>
@endsection