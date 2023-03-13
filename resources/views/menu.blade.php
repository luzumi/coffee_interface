@extends('layouts.app')

@section('content')
    <div class="in-progress">
        @yield('progress')
    </div>


    <div class="grid_menu">
        <div class="title_app">
            <h1>Get me Coffee</h1>
        </div>
        <div class="title_welcome">
            <h2>Willkommen, {{ $viewData['user']->username }}!</h2>
        </div>
        <div class="bg_img1"></div>

        <div class="menu-statistics">
            <div class="menu-statistics-item">
                <h3>Bestellungen</h3>
                <p>{{ $viewData['orders']->count() }}</p>
            </div>
            <div class="menu-statistics-item">
                <h3>Letzte Bestellung:&nbsp;</h3>
                <p>{{ $viewData['orders']->last()->updated_at->format('d.m.Y - H:i') ?? '' }}</p>
            </div>
            <div class="menu-statistics-item">
                <h3>Letzter Auswahl</h3>
                <p> {{ $viewData['orders']->last()->coffee_name??''}}</p>
            </div>
            <div class="menu-statistics-item">
                <h3>Guthaben</h3>
                <p> {{ $viewData['user']->credits }} Credits</p>
            </div>
        </div>

        <div class="menu-varieties">
            <div class="menu-varieties-header">
                <p class="menu-varieties-header-2">Getränk</p>
                <p class="menu-varieties-header-3">Kosten</p>
            </div>
            @foreach($viewData['varieties'] as $key => $variety)
                @if($variety->coffee_name == 'noch keine Auswahl getroffen') @continue @endif

                <div class="menu-varieties-item menu-varieties-item-{{$key}}">

                @if( $viewData['role'] != 'maintenance' &&
                            $viewData['role'] != 'vip' &&
                            $viewData['user']->credits < $variety->credit_cost )
                        <form  class="order-form">
                            @csrf
                            <button type="button" class="btn menu-varieties-item-button menu-varieties-item-button-{{ $key }}"></button>
                        </form>
                        <div class="menu-varieties-item menu-varieties-item-{{$key}} ">
                            <h5>Bitte Guthaben aufladen.</h5>
                        </div>

                @else
                    <form method="POST" action="{{ route('new_order', ['type' => $variety->coffee_code]) }}"
                          class="order-form">
                        @csrf
                        <button type="submit"
                                class="btn menu-varieties-item-button menu-varieties-item-button-{{$key}}"></button>
                    </form>
                @endif

                @if( $viewData['role'] != 'maintenance' &&
                            $viewData['role'] != 'vip' &&
                            $viewData['user']->credits >= $variety->credit_cost )
                    <div class="menu-varieties-item-name menu-varieties-item-name-{{$key}}">
                        <h3>{{ $variety->coffee_name }}</h3>
                    </div>
                @endif
                    <div class="menu-varieties-item-price menu-varieties-item-price-{{$key}}">
                        @if($viewData['role'] == 'maintenance' || $viewData['role'] == 'vip')
                            <p>0 Credits</p>
                        @else
                            <p>{{ $variety->credit_cost }} Credits</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="menu-logout">
            <form method="GET" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn menu-logout-button">Logout</button>
            </form>
        </div>

        @if ($viewData['role'] == 'maintenance')
            <div class="maintenance-mode">Hinweis! Maintenance-Mode aktiv - zum Beenden Logout drücken oder Rfid-Karte
                erneut auflegen
            </div>
        @endif
    </div>
@endsection




