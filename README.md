# EvolvingMe 🌱

**EvolvingMe** ist eine innovative Anwendung, die dir dabei hilft, dich selbst zu entwickeln und deine Fortschritte in verschiedenen Lebensbereichen zu verfolgen. Egal ob Fitness, Psyche, Ernährung oder Verhalten – diese App wird dein persönlicher Begleiter auf dem Weg zu einem besseren Ich. 🎯

## Vision 🚀

Die Vision von **EvolvingMe** ist es, eine zentrale Plattform zu schaffen, die alle Aspekte der persönlichen Entwicklung abdeckt. Die App soll dir helfen, deine Ziele zu setzen, Fortschritte zu dokumentieren und wertvolle Einblicke in dein Leben zu gewinnen. 

In Zukunft wird die App folgende Bereiche unterstützen:
- **Fitness** 💪: Verfolge dein Gewicht, deine Workouts und deine körperliche Entwicklung.
- **Psyche** 🧠: Dokumentiere deine Stimmung, reflektiere deine Gedanken und verbessere dein mentales Wohlbefinden.
- **Ernährung** 🥗: Halte deine Mahlzeiten fest, plane deine Ernährung und analysiere deine Essgewohnheiten.
- **Verhalten** 📝: Beobachte deine täglichen Routinen, identifiziere Muster und arbeite an positiven Veränderungen.

## Aktueller Stand 📊

Derzeit besteht die Anwendung aus zwei Hauptkomponenten:
1. **Server** 🖥️: Ein Java-basierter Server, der die Daten verarbeitet und speichert.
2. **Client** 🌐: Eine PHP- und JavaScript-basierte Webanwendung, die eine benutzerfreundliche Oberfläche bietet.

## Features (Geplant und Aktuell) ✨

### Aktuelle Features
- Einfache Eingabe von Daten wie Gewicht und Stimmung 📝
- Speicherung der Daten lokal in einer JSON-Datei 💾
- KI-Analyse deiner Fortschritte mit ChatGPT Integration 🤖
- Benutzerfreundliche Suche nach Namen 🔍
- Dunkles Design mit anpassbarem Hintergrund 🎨
- Verlaufsanalyse mit vorherigen Einträgen 📈

### Geplante Features
- Erweiterte KI-Analysen und Empfehlungen 🧠
- Diagramme zur Visualisierung von Fortschritten 📊
- Mobile App-Version für iOS und Android 📱
- Cloud-Synchronisation ☁️
- Erinnerungsfunktion 🔔

## Installation 🛠️

### Voraussetzungen
- **Node.js** 📦 (mit npm) - [Download](https://nodejs.org/)
- **PHP 8.4+** 🐘 - [Download](https://windows.php.net/download#php-8.4)
- **Electron** ⚡ für die Desktop-Anwendung
- **Java 17+** ☕ (optional für Server)

### PHP Installation (Windows) 🐘

1. **Download PHP** 📥
   - Gehe zu [windows.php.net/download#php-8.4](https://windows.php.net/download#php-8.4)
   - Wähle "VS16 x64 Thread Safe" ZIP-Paket
   - Lade die ZIP-Datei herunter

2. **PHP Einrichtung** 📂
   ```bash
   # Erstelle PHP-Ordner
   mkdir C:\php
   # Entpacke ZIP-Datei nach C:\php
   ```

## Nutzung
- Öffne die Electron-Anwendung.
- Gib Daten wie Name, Gewicht und Stimmung ein und speichere sie.
- Suche nach gespeicherten Daten basierend auf dem Namen.
- Die Daten werden lokal in einer JSON-Datei gespeichert.

## Fehlerbehebung

### Häufige Probleme
1. **`php` wird nicht erkannt**:
   - Stelle sicher, dass PHP korrekt installiert ist und in der Umgebungsvariable `PATH` verfügbar ist.
2. **Electron lädt `index.php` nicht**:
   - Stelle sicher, dass der PHP-Server läuft und die Datei `main.js` korrekt konfiguriert ist.
3. **Fehler beim Starten von `npm start`**:
   - Überprüfe, ob die Datei `package.json` im Client-Verzeichnis vorhanden ist und ein gültiges `start`-Skript enthält.

### Debugging
- Öffne die Entwicklerkonsole in Electron (F12), um Fehler im JavaScript-Code zu überprüfen.
- Überprüfe die Logs des PHP-Servers und von Electron im Terminal.

## Contributing

Contributions sind willkommen! Bitte fühle dich frei, Pull Requests einzureichen oder Issues zu erstellen, um Vorschläge oder Verbesserungen zu teilen.

## License

Dieses Projekt ist unter der MIT-Lizenz lizenziert. Siehe die Datei `LICENSE` für weitere Details.
