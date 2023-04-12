@extends('layouts.app')

@section('content')
    <h1>RFID-Karte</h1>
    <ol>
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
