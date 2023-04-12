@extends('layouts.app')

@section('content')
    <div class="overlay"></div>

    <div class="title_app">
        <h1>Get me Coffee - </h1>

        <h1 class="title_welcome"> &nbsp;Help - Menu</h1>
    </div>
    <ol class="help-text">
        <li><strong>Getränk auswählen:</strong> Wählen Sie das gewünschte Getränk aus der Getränkeliste aus.</li>
        <li><strong>Menü-Übersicht:</strong>
            <ul>
                <li><em>Home:</em> Zeigt die Startseite mit Getränkeauswahl.</li>
                <li><em>Getränke:</em> Zeigt eine Liste der verfügbaren Getränke zur Auswahl.</li>
                <li><em>Guthaben:</em> Zeigt Ihr aktuelles Guthaben an.</li>
                <li><em>Profil:</em> Zeigt Ihr Profil mit persönlichen Informationen.</li>
                <li><em>Logout:</em> Loggt Sie aus dem System aus.</li>
            </ul>
        </li>
    </ol>

@endsection
