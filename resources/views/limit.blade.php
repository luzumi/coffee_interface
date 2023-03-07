@extends('menu')

@section('limit')
    <div class="overlay-limit"></div>
    <div class="menu-varieties-item menu-varieties-item-{{$viewData['key']}}">
        <h4>Zu wenig Guthaben!</h4>
        <h5>Bitte aufladen.</h5>
    </div>
@endsection
