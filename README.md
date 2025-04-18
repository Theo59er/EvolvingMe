# EvolvingMe 🌱

**EvolvingMe** ist eine innovative Anwendung, die dir dabei hilft, dich selbst zu entwickeln und deine Fortschritte in verschiedenen Lebensbereichen zu verfolgen. Egal ob Fitness, Psyche, Ernährung oder Verhalten – diese App wird dein persönlicher Begleiter auf dem Weg zu einem besseren Ich. 🎯

## Vision 🚀

Die Vision von **EvolvingMe** ist es, eine zentrale Plattform zu schaffen, die alle Aspekte der persönlichen Entwicklung abdeckt. Die App soll dir helfen, deine Ziele zu setzen, Fortschritte zu dokumentieren und wertvolle Einblicke in dein Leben zu gewinnen. 

### Kernbereiche 🎯
- **Fitness** 💪: Verfolge dein Gewicht, deine Workouts und deine körperliche Entwicklung
- **Psyche** 🧠: Dokumentiere deine Stimmung und reflektiere deine Gedanken
- **Ernährung** 🥗: Analysiere deine Essgewohnheiten und plane gesunde Mahlzeiten
- **Verhalten** 📝: Identifiziere Muster und arbeite an positiven Veränderungen

## Aktueller Stand 📊

Die App besteht aus einer PHP-basierten Webanwendung mit folgenden Features:

### Aktuelle Features ✨
- **Datenerfassung** 📝
  - Name, Gewicht, Stimmung und detaillierte Tagesnotizen
  - Strukturierte Eingabefelder für bessere Analyse
  - Automatische Datenspeicherung pro Benutzer
  - Kombinierter "Speichern + KI Analyse" Button

- **KI-Integration** 🤖
  - Lokale KI-Analyse durch LM Studio Integration
  - Verlaufsbasierte KI-Empfehlungen
  - Strukturierte Analysen in Kategorien
  - Aufklappbare KI-Analysen mit Effekten
  - Echtzeitanalyse beim Speichern möglich

- **Benutzerfreundlichkeit** 🎨
  - Modernes Interface im Darkmode-Design
  - Glasmorphismus-Effekte
  - Responsive Layout
  - Animierte UI-Elemente
  - Verbesserte Lesbarkeit durch Kontraste

- **Datenverwaltung** 💾
  - Separate JSON-Dateien pro Benutzer
  - Verlaufsansicht mit Filteroptionen
  - Kopier-Funktionen für Prompts und Daten
  - Automatische Zeitstempel (Europa/Berlin)

### Technische Voraussetzungen
- **PHP 8.4+** 🐘
- **LM Studio** (lokal) 🧠
- **Webbrowser** 🌐

### Installation

1. **Repo klonen**
```bash
git clone https://github.com/yourusername/EvolvingMe.git
cd EvolvingMe
```

2. **LM Studio einrichten**
- LM Studio installieren
- Mistral-Nemo-Instruct Modell laden
- API-Server auf Port 1234 starten

3. **PHP konfigurieren**
```bash
# Timezone auf Europe/Berlin setzen
# curl Extension aktivieren
```

4. **Anwendung starten**
```bash
cd my-maven-app/client/public
php -S localhost:8000
```

## Nutzung 📱

1. **Daten erfassen**
   - Name und Messwerte eingeben
   - Tagesnotizen strukturiert erfassen
   - "Speichern + KI Analyse" für sofortige Auswertung

2. **KI-Analyse**
   - Automatische Analyse durch LM Studio
   - Strukturierte Kategorien
   - Verlaufsbasierte Empfehlungen

3. **Fortschritt tracken**
   - Verlauf anzeigen
   - KI-Empfehlungen lesen
   - Entwicklung beobachten

## Contributing 🤝

Beiträge sind willkommen! Bitte beachte:
1. Fork das Projekt
2. Erstelle einen Feature Branch
3. Committe deine Änderungen
4. Push zu dem Branch
5. Öffne einen Pull Request

## Lizenz 📄

Dieses Projekt ist unter der MIT-Lizenz lizenziert. Details in der `LICENSE`-Datei.
