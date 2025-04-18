<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EvolvingMe</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            background: url('data/wallpaper.jpg') center/cover no-repeat fixed;
            /* Fallback wenn kein Bild vorhanden */
            background: linear-gradient(135deg,rgb(0, 132, 255) 0%,rgb(0, 0, 0) 50%, #e0e0e0 100%);
        }
        
        .section {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.9); /* Leicht transparenter Hintergrund */
            backdrop-filter: blur(5px); /* Verschwommener Effekt */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .copy-button {
            background: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .ai-feedback {
            background: #f5f5f5;
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #4CAF50;
        }
    </style>
</head>
<body>
    <div class="section">
        <h1>EvolvingMe - Daten erfassen</h1>
        <form action="save_data.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" required><br><br>

            <label for="weight">Gewicht (kg):</label>
            <input type="number" step="0.1" name="weight" required><br><br>

            <label for="mood">Stimmung (1-10):</label>
            <input type="number" min="1" max="10" name="mood" required><br><br>

            <label for="notes">Tagesnotizen:</label>
            <textarea name="notes" placeholder="Beschreibe deinen Tag strukturiert:
- Ernährung: Was hast du gegessen?
- Fitness: Welche Übungen, wie viele Wiederholungen?
- Aktivitäten: Was hast du unternommen?
- Gefühl: Wie fühlst du sich dabei?" rows="6" cols="50"></textarea><br><br>

            <input type="submit" value="Speichern">
        </form>
    </div>

    <div class="section">
        <h2>Daten suchen</h2>
        <form action="index.php" method="GET">
            <label for="search">Name suchen:</label>
            <input type="text" name="search" required>
            <input type="submit" value="Suchen">
        </form>

        <?php
        if (isset($_GET['search'])) {
            $searchName = $_GET['search'];
            $jsonFile = __DIR__ . '/data/userData.json';
            
            if (file_exists($jsonFile)) {
                $jsonContent = file_get_contents($jsonFile);
                $allData = json_decode($jsonContent, true);
                
                // Prüfe ob $allData ein Array ist
                if (!is_array($allData)) {
                    $allData = []; // Initialisiere leeres Array wenn keine gültigen Daten
                }
                
                $results = array_filter($allData, function($entry) use ($searchName) {
                    return isset($entry['name']) && 
                           strtolower($entry['name']) === strtolower($searchName);
                });

                if (!empty($results)) {
                    echo "<h3>Gefundene Einträge für: " . htmlspecialchars($searchName) . "</h3>";
                    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                    echo "<tr><th>Datum</th><th>Gewicht</th><th>Stimmung</th><th>Notizen</th></tr>";
                    
                    foreach ($results as $entry) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($entry['timestamp']) . "</td>";
                        echo "<td>" . htmlspecialchars($entry['weight']) . " kg</td>";
                        echo "<td>" . htmlspecialchars($entry['mood']) . "/10</td>";
                        echo "<td>" . htmlspecialchars($entry['notes']) . "</td>";
                        echo "</tr>";
                    }
                    
                    echo "</table>";
                } else {
                    echo "<p>Keine Einträge für diesen Namen gefunden.</p>";
                }
            } else {
                echo "<p>Noch keine Daten vorhanden.</p>";
            }
        }
        ?>
    </div>

    <div class="section">
        <h2>KI-Analyse Generator</h2>
        <?php
        if (isset($_GET['search'])) {
            $searchName = $_GET['search'];
            $jsonFile = __DIR__ . '/data/userData.json';
            
            if (file_exists($jsonFile)) {
                $jsonContent = file_get_contents($jsonFile);
                $allData = json_decode($jsonContent, true);
                
                $latestEntry = array_filter($allData, function($entry) use ($searchName) {
                    return isset($entry['name']) && 
                           strtolower($entry['name']) === strtolower($searchName);
                });
                
                if (!empty($latestEntry)) {
                    $entry = end($latestEntry);
                    
                    // Formular für KI-Analyse-Update
                    echo "<div class='ai-feedback'>";
                    echo "<h3>KI-Analyse aktualisieren:</h3>";
                    echo "<form action='update_ai_analysis.php' method='POST'>";
                    echo "<input type='hidden' name='name' value='" . htmlspecialchars($searchName) . "'>";
                    echo "<textarea name='ai_analysis' rows='10' cols='50' placeholder='Fügen Sie hier die neue KI-Analyse ein...'></textarea><br><br>";
                    echo "<input type='submit' value='KI-Analyse speichern' class='copy-button'>";
                    echo "</form>";
                    echo "</div>";

                    // Bestehende Analyse anzeigen
                    echo "<div class='ai-feedback'>";
                    echo "<h3>Letzte KI-Analyse:</h3>";
                    if (isset($entry['current_ai_analysis'])) {
                        echo "<strong>Datum:</strong> " . htmlspecialchars($entry['current_ai_analysis']['analysis_date']) . "<br>";
                        echo "<strong>Gesamtfortschritt:</strong> " . htmlspecialchars($entry['current_ai_analysis']['overall_progress']) . "<br>";
                        echo "<strong>Fitness:</strong> " . htmlspecialchars($entry['current_ai_analysis']['fitness_analysis']) . "<br>";
                        echo "<strong>Ernährung:</strong> " . htmlspecialchars($entry['current_ai_analysis']['nutrition_analysis']) . "<br>";
                        echo "<strong>Stimmung:</strong> " . htmlspecialchars($entry['current_ai_analysis']['mood_analysis']) . "<br>";
                        echo "<strong>Empfehlungen:</strong><ul>";
                        foreach ($entry['current_ai_analysis']['recommendations'] as $rec) {
                            echo "<li>" . htmlspecialchars($rec) . "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>Keine KI-Analyse verfügbar</p>";
                    }
                    echo "</div>";
                    
                    // Kopier-Buttons
                    echo "<h3>KI-Prompt kopieren:</h3>";
                    echo "<button class='copy-button' onclick='copyToClipboard(`" . htmlspecialchars($entry['analysis_prompt']) . "`)'>Prompt kopieren</button>";
                    echo "<button class='copy-button' onclick='copyToClipboard(`" . htmlspecialchars($jsonContent) . "`)'>JSON kopieren</button>";
                }
            }
        }
        ?>
    </div>

    <script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('In Zwischenablage kopiert!');
        }).catch(function(err) {
            console.error('Fehler beim Kopieren:', err);
        });
    }
    </script>
</body>
</html>