<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jsonFile = __DIR__ . '/data/userData.json';
    $name = $_POST['name'] ?? '';
    $newAnalysis = $_POST['ai_analysis'] ?? '';

    // Stelle sicher, dass der data Ordner existiert
    if (!file_exists(__DIR__ . '/data')) {
        mkdir(__DIR__ . '/data', 0777, true);
    }

    // Lade existierende Daten oder erstelle leeres Array
    $allData = [];
    if (file_exists($jsonFile)) {
        $jsonContent = file_get_contents($jsonFile);
        $allData = json_decode($jsonContent, true) ?? [];
    }

    // Sicherheitscheck
    if (!is_array($allData)) {
        $allData = [];
    }

    // Finde den letzten Eintrag für den Benutzer
    $userEntries = array_filter($allData, function($entry) use ($name) {
        return isset($entry['name']) && 
               strtolower($entry['name']) === strtolower($name);
    });

    if (!empty($userEntries)) {
        $lastEntry = array_values($userEntries)[count($userEntries) - 1];
        
        // Aktualisiere den spezifischen Eintrag
        foreach ($allData as &$entry) {
            if (isset($entry['name']) && 
                strtolower($entry['name']) === strtolower($name) && 
                $entry['timestamp'] === $lastEntry['timestamp']) {
                
                // Speichere die vorherige Analyse
                $entry['last_ai_feedback'] = isset($entry['current_ai_analysis']) 
                    ? $entry['current_ai_analysis']['overall_progress']
                    : null;

                // Aktualisiere die aktuelle Analyse
                $entry['current_ai_analysis'] = [
                    'analysis_date' => date('Y-m-d H:i:s'),
                    'overall_progress' => $newAnalysis,
                    'fitness_analysis' => extractAnalysisPart($newAnalysis, 'Fitness'),
                    'nutrition_analysis' => extractAnalysisPart($newAnalysis, 'Ernährung'),
                    'mood_analysis' => extractAnalysisPart($newAnalysis, 'Mentales'),
                    'recommendations' => extractRecommendations($newAnalysis)
                ];
                break;
            }
        }
        unset($entry); // Wichtig: Referenz aufheben

        // Backup erstellen
        if (file_exists($jsonFile)) {
            copy($jsonFile, $jsonFile . '.backup');
        }

        // Speichere die aktualisierten Daten
        $jsonString = json_encode($allData, JSON_PRETTY_PRINT);
        if ($jsonString === false) {
            error_log("JSON encode error: " . json_last_error_msg());
        } else {
            if (file_put_contents($jsonFile, $jsonString) === false) {
                // Wenn Speichern fehlschlägt, stelle Backup wieder her
                if (file_exists($jsonFile . '.backup')) {
                    copy($jsonFile . '.backup', $jsonFile);
                }
                error_log("Fehler beim Speichern der Daten in: $jsonFile");
            }
        }
    }

    header("Location: index.php?search=" . urlencode($name));
    exit;
}

// Hilfsfunktionen bleiben unverändert
function extractAnalysisPart($analysis, $section) {
    if (preg_match("/$section:?\s*([^\n]+)/i", $analysis, $matches)) {
        return $matches[1];
    }
    return '';
}

function extractRecommendations($analysis) {
    $recommendations = [];
    if (preg_match("/Empfehlungen:?\s*(.+?)(?=\n\n|$)/si", $analysis, $matches)) {
        $recommendationText = $matches[1];
        preg_match_all("/[-•]\s*([^\n]+)/", $recommendationText, $matches);
        $recommendations = $matches[1] ?? [];
    }
    return array_slice($recommendations, 0, 5);
}

function generateNextPrompt($name, $entry) {
    return "Analysiere den Fortschritt von {$name} als persönlicher KI-Coach:\n\n" .
           "AKTUELLE DATEN:\n" .
           "- Datum: " . date('Y-m-d') . "\n" .
           "- Gewicht: {$entry['weight']}kg\n" .
           "- Stimmung: {$entry['mood']}/10\n" .
           "- Notizen: {$entry['notes']}\n\n" .
           "VORHERIGE ANALYSE:\n" .
           ($entry['last_ai_feedback'] ?? "[Keine vorherige Analyse verfügbar]") . "\n\n" .
           "Bitte analysiere folgende Aspekte:\n" .
           "1. Tagesübersicht & Fortschritt\n" .
           "2. Ernährungsverhalten\n" .
           "3. Fitness & Aktivität\n" .
           "4. Mentales Wohlbefinden\n" .
           "5. Konkrete Empfehlungen\n\n" .
           "Antworte in einem motivierenden, aber ehrlichen Coaching-Stil.";
}
?>