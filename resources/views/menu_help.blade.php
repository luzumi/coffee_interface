@extends('layouts.app')

@section('content')


    <div class="title_app">
        <h1>Get me Coffee - </h1>

        <h1 class="title_welcome"> &nbsp;Help - Menu</h1>
    </div>
    <ol class="help-text">
        <hr>
        <li><strong>Getränk auswählen:</strong> Wählen Sie das gewünschte Getränk aus der Getränkeliste aus.</li>
        <ul> Angezeigt werden die Auswahlmöglichkeit und der jeweilige Preis </ul>
        <ul> Reicht Ihr aktuelles Guthaben für diese Auswahlmöglichkeit nicht aus, können Sie es bei Alexander Seedorf aufladen </ul>
        <hr>
        <li><strong>Menü-Statistiken:</strong>
            <ul>
                <li><em>Bestellungen:</em> Zeigt die Anzahl Ihrer getätigten Bestellungen</li>
                <li><em>letzte Bestellung:</em> Ihr letzter Besuch</li>
                <li><em>Letzte Auswahl:</em> Ihre letzte getätigte Auswahl</li>
                <li><em>Benutzergruppe:</em> Ihr Account ist Mitglied der Gruppe</li>
            </ul>
        </li>
        <hr>
    </ol>
    <div class="menu-logout">
        <form method="GET" action="{{ route('help') }}">
            <button type="submit" class="btn menu-logout-button">Zurück</button>
        </form>
    </div>
@endsection
