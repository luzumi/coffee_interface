@extends('layouts.app')

@section('content')
    <div class="overlay"></div>

    <div class="title_app">
        <h1>Get me Coffee - </h1>

        <h1 class="title_welcome"> &nbsp;Help - RFID</h1>
    </div>
    <ol class="help-text">
        <li><strong>Einloggen:</strong> Halten Sie Ihre RFID-Karte an das Lesegerät, um sich einzuloggen.</li>
        <li><strong>Guthaben aufladen:</strong> Sie können Ihr Guthaben bei Alexander Seedorf aufladen.</li>
        <li><strong>Neue RFID-Karte registrieren:</strong>
            <ol>
                <li>Loggen Sie sich mit Ihrer RFID-Karte ein.</li>
                <li>Ihre Karte wird gelesen und ins System eingetragen.</li>
                <li>Klicken Sie auf "RFID-Karte wechseln".</li>
                <li>Halten Sie die neue RFID-Karte an das Lesegerät.</li>
                <li>Ihre neue RFID-Karte ist nun registriert und einsatzbereit.</li>
            </ol>
        </li>
    </ol>
@endsection
