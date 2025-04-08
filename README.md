# EvolvingMe

**EvolvingMe** ist eine innovative Anwendung, die dir dabei hilft, dich selbst zu entwickeln und deine Fortschritte in verschiedenen Lebensbereichen zu verfolgen. Egal ob Fitness, Psyche, Ernährung oder Verhalten – diese App wird dein persönlicher Begleiter auf dem Weg zu einem besseren Ich.

## Vision

Die Vision von **EvolvingMe** ist es, eine zentrale Plattform zu schaffen, die alle Aspekte der persönlichen Entwicklung abdeckt. Die App soll dir helfen, deine Ziele zu setzen, Fortschritte zu dokumentieren und wertvolle Einblicke in dein Leben zu gewinnen. 

In Zukunft wird die App folgende Bereiche unterstützen:
- **Fitness**: Verfolge dein Gewicht, deine Workouts und deine körperliche Entwicklung.
- **Psyche**: Dokumentiere deine Stimmung, reflektiere deine Gedanken und verbessere dein mentales Wohlbefinden.
- **Ernährung**: Halte deine Mahlzeiten fest, plane deine Ernährung und analysiere deine Essgewohnheiten.
- **Verhalten**: Beobachte deine täglichen Routinen, identifiziere Muster und arbeite an positiven Veränderungen.

## Aktueller Stand

Derzeit besteht die Anwendung aus zwei Hauptkomponenten:
1. **Server**: Ein Java-basierter Server, der die Daten verarbeitet und speichert.
2. **Client**: Eine PHP- und JavaScript-basierte Webanwendung, die eine benutzerfreundliche Oberfläche bietet, um Daten einzugeben und Ergebnisse anzuzeigen.

## Features (Geplant und Aktuell)

### Aktuelle Features
- Einfache Eingabe von Daten wie Gewicht und Stimmung.
- Speicherung der Daten lokal in einer JSON-Datei im Projektverzeichnis.
- Suche nach gespeicherten Daten basierend auf dem Namen.
- Integration eines lokalen PHP-Servers für die Ausführung von PHP-Dateien.
- Nutzung von Electron, um die Anwendung als Desktop-App auszuführen.

### Geplante Features
- Erweiterte Analyse-Tools für Fitness, Ernährung und Verhalten.
- Integration von Diagrammen und Statistiken zur Visualisierung von Fortschritten.
- Personalisierte Empfehlungen basierend auf deinen Daten.
- Unterstützung für mehrere Benutzerprofile.
- Mobile App-Version für iOS und Android.

## Installation

### Voraussetzungen
- **Node.js** (mit npm) für die Verwaltung von JavaScript-Abhängigkeiten.
- **PHP 7.4+** für die Ausführung des PHP-Servers.
- **Electron** für die Desktop-Anwendung.
- **Maven** für die Verwaltung der Java-Abhängigkeiten des Servers.
- **Java 17+** für den Server.

### Schritte

#### 1. Repository klonen
```bash
git clone https://github.com/username/EvolvingMe.git
cd EvolvingMe
```

#### 2. Client einrichten
1. Navigiere in das Client-Verzeichnis:
   ```bash
   cd my-maven-app/client/public
   ```
2. Installiere die benötigten Node.js-Abhängigkeiten:
   ```bash
   npm install
   ```
3. Stelle sicher, dass die Datei `package.json` einen `start`-Befehl enthält:
   ```json
   {
     "scripts": {
       "start": "electron ."
     }
   }
   ```

#### 3. PHP installieren
1. Lade PHP von [https://windows.php.net/download/](https://windows.php.net/download/) herunter.
2. Entpacke die ZIP-Datei in ein Verzeichnis, z. B. `C:\php`.
3. Füge den PHP-Pfad zur Umgebungsvariable `PATH` hinzu:
   - Öffne die **Systemsteuerung** > **System** > **Erweiterte Systemeinstellungen** > **Umgebungsvariablen**.
   - Bearbeite die Variable `Path` und füge `C:\php` hinzu.
4. Überprüfe die Installation:
   ```bash
   php -v
   ```

#### 4. Electron einrichten
1. Installiere Electron global:
   ```bash
   npm install -g electron
   ```

#### 5. Anwendung starten
1. Starte den PHP-Server:
   ```bash
   php -S localhost:8000
   ```
2. Starte die Electron-Anwendung:
   ```bash
   npm start
   ```

#### 6. Server einrichten (optional)
1. Navigiere in das Server-Verzeichnis:
   ```bash
   cd my-maven-app/server
   ```
2. Installiere die Abhängigkeiten und starte den Server:
   ```bash
   mvn spring-boot:run
   ```

### Nutzung
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
