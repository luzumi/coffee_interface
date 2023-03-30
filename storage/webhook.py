import requests
import json

url = "http://192.168.2.111:8000/webhook"

# Erstelle ein JSON-Objekt
data = {
    "tag_uid": "182-232-225-89-230",
    "disruption": False,
    "need_service": False
}

# Konvertiere das JSON-Objekt in einen JSON-String
json_data = json.dumps(data)
while(True):
    # Sende den Webhook
    response = requests.post(url, data=json_data, headers={'Content-Type': 'application/json'})

    # Zeige die Antwort des Servers an
    print(response.status_code)
    print(response.text)

    # Warte auf Benutzereingabe, bevor das Programm beendet wird
    input("Drücke Enter, um neuen Webhook zu senden...")
