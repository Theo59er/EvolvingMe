<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dataDir = __DIR__ . '/data';
    $name = $_POST['name'] ?? '';
    
    // Sichere Dateinamen erstellen
    $safeName = preg_replace('/[^a-z0-9]/i', '_', strtolower($name));
    $userDataFile = $dataDir . '/' . $safeName . '_data.json';
    $userAiFile = $dataDir . '/' . $safeName . '_ai.json';

    // Stelle sicher, dass der data Ordner existiert
    if (!file_exists($dataDir)) {
        mkdir($dataDir, 0777, true);
    }

    // Lade existierende Daten und letzte AI Analyse
    $userData = [];
    $lastAiFeedback = null;
    if (file_exists($userDataFile)) {
        $userData = json_decode(file_get_contents($userDataFile), true) ?? [];
        if (!empty($userData)) {
            $lastEntry = end($userData);
            $lastAiFeedback = $lastEntry['ai_feedback'] ?? null;
        }
    }

    // Neuer Dateneintrag
    $newEntry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'name' => $_POST['name'],
        'weight' => $_POST['weight'],
        'mood' => $_POST['mood'],
        'notes' => $_POST['notes'],
        'ai_feedback' => null, // Wird später durch KI-Analyse gefüllt
        'previous_ai_feedback' => $lastAiFeedback, // Speichere vorherige Analyse
        'analysis_prompt' => generateNextPrompt($_POST['name'], [
            'weight' => $_POST['weight'],
            'mood' => $_POST['mood'],
            'notes' => $_POST['notes'],
            'last_ai_feedback' => $lastAiFeedback
        ])
    ];

    // Füge neuen Eintrag hinzu
    $userData[] = $newEntry;

    // Speichere Nutzerdaten
    if (file_put_contents($userDataFile, json_encode($userData, JSON_PRETTY_PRINT)) === false) {
        error_log("Fehler beim Speichern der Nutzerdaten: $userDataFile");
    }

    header('Location: index.php');
    exit;
}

function generateNextPrompt($name, $data) {
    // Lade historische Daten für Benutzer-Profil
    $safeName = preg_replace('/[^a-z0-9]/i', '_', strtolower($name));
    $userDataFile = __DIR__ . '/data/' . $safeName . '_data.json';
    $userProfile = [];
    
    if (file_exists($userDataFile)) {
        $allData = json_decode(file_get_contents($userDataFile), true) ?? [];
        if (!empty($allData)) {
            // Berechne Durchschnittswerte und sammle Informationen
            $totalWeight = 0;
            $totalMood = 0;
            $entries = count($allData);
            $recentGoals = [];
            $activities = [];
            
            foreach ($allData as $entry) {
                $totalWeight += floatval($entry['weight']);
                $totalMood += intval($entry['mood']);
                // Sammle einzigartige Aktivitäten und Ziele aus Notizen
                if (!empty($entry['notes'])) {
                    if (preg_match('/Ziele?:([^\n]+)/i', $entry['notes'], $matches)) {
                        $recentGoals[] = trim($matches[1]);
                    }
                    if (preg_match('/Aktivit\w+:([^\n]+)/i', $entry['notes'], $matches)) {
                        $activities[] = trim($matches[1]);
                    }
                }
            }

            $userProfile = [
                'avg_weight' => $entries > 0 ? round($totalWeight / $entries, 1) : 0,
                'avg_mood' => $entries > 0 ? round($totalMood / $entries, 1) : 0,
                'total_entries' => $entries,
                'tracking_since' => $allData[0]['timestamp'] ?? 'unbekannt',
                'recent_goals' => array_slice(array_unique($recentGoals), -3),
                'common_activities' => array_slice(array_unique($activities), -3)
            ];
        }
    }

    return "Analysiere den Fortschritt von {$name} als persönlicher KI-Coach:\n\n" .
           "AKTUELLE DATEN:\n" .
           "- Datum: " . date('Y-m-d') . "\n" .
           "- Gewicht: {$data['weight']}kg\n" .
           "- Stimmung: {$data['mood']}/10\n" .
           "- Notizen: {$data['notes']}\n\n" .
           "VORHERIGE KI-ANALYSE:\n" .
           ($data['last_ai_feedback'] ?? "[Keine vorherige Analyse verfügbar]") . "\n\n" .
           "BENUTZER-PROFIL:\n" .
           "- Tracking seit: " . ($userProfile['tracking_since'] ?? 'Heute') . "\n" .
           "- Durchschnittliches Gewicht: " . ($userProfile['avg_weight'] ?? $data['weight']) . "kg\n" .
           "- Durchschnittliche Stimmung: " . ($userProfile['avg_mood'] ?? $data['mood']) . "/10\n" .
           "- Letzte Ziele: " . (!empty($userProfile['recent_goals']) ? implode(", ", $userProfile['recent_goals']) : "Keine bisherigen Ziele") . "\n" .
           "- Häufige Aktivitäten: " . (!empty($userProfile['common_activities']) ? implode(", ", $userProfile['common_activities']) : "Keine bisherigen Aktivitäten") . "\n\n" .
           "Bitte analysiere folgende Aspekte:\n" .
           "1. Tagesübersicht & Fortschritt (im Vergleich zum Durchschnitt)\n" .
           "2. Ernährungsverhalten\n" .
           "3. Fitness & Aktivität\n" .
           "4. Mentales Wohlbefinden\n" .
           "5. Konkrete Empfehlungen (basierend auf bisherigen Zielen)\n\n" .
           "Antworte in einem motivierenden, aber ehrlichen Coaching-Stil. " .
           "Beziehe dich auf vorherige Ziele und Aktivitäten wenn möglich.\n\n" .
           "HINWEIS: Behalte deine Antwort kompakt und informativ.\n ".
           "6. Baue einen kurzen text über die Aktuelle Person damit du ihn späteren analysen langzeit entwicklung von interessen etc findest maximal 500 zeichen\n";
}

// In der "Daten suchen" Section, wo die KI-Analysen angezeigt werden:
if (file_exists($userAiFile)) {
    $aiData = json_decode(file_get_contents($userAiFile), true) ?? [];
    if (!empty($aiData)) {
        echo "<h3>KI-Analysen Verlauf</h3>";
        foreach ($aiData as $index => $analysis) {
            $timestamp = htmlspecialchars($analysis['timestamp']);
            echo "<button class='collapsible'>Analyse vom {$timestamp}</button>";
            echo "<div class='analysis-content'>";
            echo "<div class='analysis-inner'>";
            echo "<strong>Analyse:</strong><br>";
            echo nl2br(htmlspecialchars($analysis['analysis'])) . "<br>";
            if (isset($analysis['structured_analysis'])) {
                echo "<div style='margin-top: 10px;'>";
                echo "<strong>Fitness:</strong> " . htmlspecialchars($analysis['structured_analysis']['fitness_analysis']) . "<br>";
                echo "<strong>Ernährung:</strong> " . htmlspecialchars($analysis['structured_analysis']['nutrition_analysis']) . "<br>";
                echo "<strong>Mentales:</strong> " . htmlspecialchars($analysis['structured_analysis']['mood_analysis']) . "<br>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        }
    }
}
?>

<style>
    /* ...existing styles... */
    
    .collapsible {
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
        padding: 10px 15px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        border-radius: 4px;
        margin: 5px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .collapsible:after {
        content: '▼';
        font-size: 13px;
        color: white;
    }

    .active:after {
        content: '▲';
    }

    .analysis-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
        background-color: #f9f9f9;
        border-radius: 0 0 4px 4px;
    }

    .analysis-inner {
        padding: 15px;
    }
</style>

<script>
// ...existing copyToClipboard function...

document.addEventListener('DOMContentLoaded', function() {
    var coll = document.getElementsByClassName("collapsible");
    for (var i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }
});
</script>