<?php
date_default_timezone_set('Europe/Berlin');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dataDir = __DIR__ . '/data';
    $name = $_POST['name'] ?? '';
    $newAnalysis = $_POST['ai_analysis'] ?? '';

    // Sichere Dateinamen erstellen
    $safeName = preg_replace('/[^a-z0-9]/i', '_', strtolower($name));
    $userDataFile = $dataDir . '/' . $safeName . '_data.json';
    $userAiFile = $dataDir . '/' . $safeName . '_ai.json';

    // Stelle sicher, dass der data Ordner existiert
    if (!file_exists($dataDir)) {
        mkdir($dataDir, 0777, true);
    }

    // Lade existierende KI-Analysen
    $aiData = [];
    if (file_exists($userAiFile)) {
        $aiContent = file_get_contents($userAiFile);
        if ($aiContent !== false) {
            $aiData = json_decode($aiContent, true) ?? [];
        }
    }

    // Erstelle neuen KI-Analyse-Eintrag
    $newAiEntry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'analysis' => $newAnalysis,
        'structured_analysis' => [
            'overall_progress' => $newAnalysis,
            'fitness_analysis' => extractAnalysisPart($newAnalysis, 'Fitness'),
            'nutrition_analysis' => extractAnalysisPart($newAnalysis, 'Ernährung'),
            'mood_analysis' => extractAnalysisPart($newAnalysis, 'Mentales'),
            'recommendations' => extractRecommendations($newAnalysis)
        ]
    ];

    // Füge neue Analyse am Anfang hinzu
    array_unshift($aiData, $newAiEntry);
    
    // Behalte maximal 10 Einträge
    $aiData = array_slice($aiData, 0, 10);

    // Speichere KI-Analysen
    if (file_put_contents($userAiFile, json_encode($aiData, JSON_PRETTY_PRINT)) === false) {
        error_log("Fehler beim Speichern der KI-Analysen: $userAiFile");
    }

    // Aktualisiere den letzten Eintrag in den Nutzerdaten
    if (file_exists($userDataFile)) {
        $userData = json_decode(file_get_contents($userDataFile), true) ?? [];
        if (!empty($userData)) {
            $lastEntry = &$userData[count($userData) - 1];
            $lastEntry['ai_feedback'] = $newAnalysis;
            
            // Speichere aktualisierte Nutzerdaten
            if (file_put_contents($userDataFile, json_encode($userData, JSON_PRETTY_PRINT)) === false) {
                error_log("Fehler beim Speichern der Nutzerdaten: $userDataFile");
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
?>