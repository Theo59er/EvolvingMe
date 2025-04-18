<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vorherigen Eintrag laden
    $jsonFile = __DIR__ . '/data/userData.json';
    $previousEntry = null;
    
    if (file_exists($jsonFile)) {
        $allData = json_decode(file_get_contents($jsonFile), true);
        if (!empty($allData)) {
            $previousEntry = end($allData);
        }
    }

    // Neue Daten sammeln
    $data = [
        'timestamp' => date('Y-m-d H:i:s'),
        'name' => $_POST['name'] ?? '',
        'weight' => $_POST['weight'] ?? '',
        'mood' => $_POST['mood'] ?? '',
        'notes' => $_POST['notes'] ?? '',
        'previous_entry' => $previousEntry ? [
            'timestamp' => $previousEntry['timestamp'],
            'weight' => $previousEntry['weight'],
            'mood' => $previousEntry['mood'],
            'notes' => $previousEntry['notes']
        ] : null,
        'last_ai_feedback' => $previousEntry['last_ai_feedback'] ?? null,
        'analysis_prompt' => "Analysiere den Fortschritt von {$_POST['name']} als persönlicher KI-Coach:\n\n" .
                           "AKTUELLE DATEN:\n" .
                           "- Datum: " . date('Y-m-d') . "\n" .
                           "- Gewicht: {$_POST['weight']}kg\n" .
                           "- Stimmung: {$_POST['mood']}/10\n" .
                           "- Notizen: {$_POST['notes']}\n\n" .
                           "VORHERIGE KI-ANALYSE:\n" .
                           ($previousEntry['last_ai_feedback'] ?? "[Keine vorherige Analyse verfügbar]") . "\n\n" .
                           "Bitte analysiere folgende Aspekte:\n" .
                           "1. Tagesübersicht & Fortschritt\n" .
                           "2. Ernährungsverhalten\n" .
                           "3. Fitness & Aktivität\n" .
                           "4. Mentales Wohlbefinden\n" .
                           "5. Konkrete Empfehlungen\n\n" .
                           "Antworte in einem motivierenden, aber ehrlichen Coaching-Stil."
    ];

    // Verzeichnis erstellen falls nicht vorhanden
    if (!file_exists(__DIR__ . '/data')) {
        mkdir(__DIR__ . '/data');
    }

    // Existierende Daten laden oder neues Array erstellen
    $allData = [];
    if (file_exists($jsonFile)) {
        $allData = json_decode(file_get_contents($jsonFile), true) ?? [];
    }

    // Neue Daten hinzufügen
    $allData[] = $data;

    // Daten speichern
    file_put_contents($jsonFile, json_encode($allData, JSON_PRETTY_PRINT));

    header('Location: index.php');
    exit;
}
?>