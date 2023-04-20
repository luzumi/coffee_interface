@extends('layouts.app')

@section('content')
    <div class="overlay"></div>

    <div class="title_app">
        <h1>Get me Coffee - </h1>

        <h1 class="title_welcome"> &nbsp;Help - RFID</h1>
    </div>
    <ol class="help-text">
        <li ><strong>Einloggen:</strong> Halten Sie Ihre RFID-Karte an das Lesegerät, um sich einzuloggen.</li>
        <li><strong>Guthaben aufladen:</strong>  Ihr Guthaben können Sie bei Alexander Seedorf aufladen.</li>
        <li><strong>Neue RFID-Karte registrieren:</strong>
            <ol>
                <li>Loggen Sie sich mit Ihrer RFID-Karte ein.</li>
                <li>Ihre Karte wird gelesen und ins System eingetragen.</li>
                <li>Ihr Code wird nun angezeigt.</li>
                <li>Merken Sie sich den Code und wenden Sie sich bei Alexander Seedorf.</li>
                <li>Bei ihm können Sie Ihre Karte aktivieren und Guthaben einzahlen.</li>
                <li>Im Anschluss ist Ihre neue RFID-Karte registriert und einsatzbereit.</li>
            </ol>
        </li>
    </ol>
@endsection
