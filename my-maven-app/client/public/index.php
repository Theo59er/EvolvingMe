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

        .collapsible-cell {
            cursor: pointer;
            position: relative;
            padding: 10px;
        }

        .collapsible-cell:after {
            content: '▼';
            font-size: 10px;
            color: #666;
            position: absolute;
            right: 5px;
            top: 5px;
        }

        .collapsible-cell.active:after {
            content: '▲';
        }

        .cell-content {
            max-height: 100px;
            overflow: hidden;
            transition: all 0.4s ease-out;
            position: relative;
            filter: blur(5px) grayscale(100%) contrast(150%);
            background: linear-gradient(45deg, 
                rgba(20, 20, 20, 0.9),
                rgba(70, 70, 70, 0.8),
                rgba(20, 20, 20, 0.9));
            background-size: 200% 200%;
            animation: gradient 4s ease infinite;
            color: rgba(255, 255, 255, 0.5);
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.3);
            padding: 15px;
            border-radius: 4px;
        }

        .cell-content.expanded {
            max-height: 1000px;
            filter: blur(0) grayscale(0%) contrast(100%);
            background: white;
            animation: none;
            color: black;
            text-shadow: none;
        }

        .collapsible-cell:hover .cell-content:not(.expanded)::before,
        .collapsible-cell:hover .cell-content:not(.expanded)::after {
            content: '✧';
            position: absolute;
            color: rgba(255, 255, 255, 0.8);
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.9),
                         0 0 25px rgba(255, 255, 255, 0.5);
            font-size: 1.2em;
        }

        @keyframes gradient {
            0% { 
                background-position: 0% 50%;
                filter: blur(5px) grayscale(100%) contrast(150%);
            }
            50% { 
                background-position: 100% 50%;
                filter: blur(6px) grayscale(100%) contrast(200%);
            }
            100% { 
                background-position: 0% 50%;
                filter: blur(5px) grayscale(100%) contrast(150%);
            }
        }

        @keyframes twinkle {
            0% { 
                transform: translate(20%, 20%) scale(0.2);
                opacity: 0;
                filter: brightness(100%);
            }
            50% { 
                transform: translate(50%, 50%) scale(1);
                opacity: 1;
                filter: brightness(200%);
            }
            100% { 
                transform: translate(80%, 80%) scale(0.2);
                opacity: 0;
                filter: brightness(100%);
            }
        }

        .star {
            position: fixed;
            pointer-events: none;
            color: white;
            text-shadow: 0 0 10px #fff,
                         0 0 20px #fff,
                         0 0 30px #fff;
            animation: fallingStar 1s linear forwards;
            z-index: 1000;
        }

        @keyframes fallingStar {
            0% {
                transform: translateY(0) scale(0.5);
                opacity: 1;
            }
            100% {
                transform: translateY(100px) scale(0.1);
                opacity: 0;
            }
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
            $safeName = preg_replace('/[^a-z0-9]/i', '_', strtolower($searchName));
            $userDataFile = __DIR__ . '/data/' . $safeName . '_data.json';
            $userAiFile = __DIR__ . '/data/' . $safeName . '_ai.json';
            
            if (file_exists($userDataFile)) {
                $userData = json_decode(file_get_contents($userDataFile), true) ?? [];
                
                if (!empty($userData)) {
                    echo "<h3>Gefundene Einträge für: " . htmlspecialchars($searchName) . "</h3>";
                    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                    echo "<tr><th>Datum</th><th>Gewicht</th><th>Stimmung</th><th>Notizen</th><th>Letzte KI-Analyse</th></tr>";
                    
                    foreach ($userData as $entry) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($entry['timestamp']) . "</td>";
                        echo "<td>" . htmlspecialchars($entry['weight']) . " kg</td>";
                        echo "<td>" . htmlspecialchars($entry['mood']) . "/10</td>";
                        echo "<td>" . nl2br(htmlspecialchars($entry['notes'])) . "</td>";
                        echo "<td class='collapsible-cell'>";
                        echo "<div class='cell-content'>" . nl2br(htmlspecialchars($entry['ai_feedback'] ?? 'Keine Analyse')) . "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    
                    echo "</table>";

                    // Zeige KI-Analysen an
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
                } else {
                    echo "<p>Keine Einträge für diesen Namen gefunden.</p>";
                }
            } else {
                echo "<p>Keine Daten für diesen Benutzer gefunden.</p>";
            }
        }
        ?>
    </div>

    <div class="section">
        <h2>KI-Analyse Generator</h2>
        <?php
        if (isset($_GET['search'])) {
            $searchName = $_GET['search'];
            $safeName = preg_replace('/[^a-z0-9]/i', '_', strtolower($searchName));
            $userDataFile = __DIR__ . '/data/' . $safeName . '_data.json';
            $userAiFile = __DIR__ . '/data/' . $safeName . '_ai.json';
            
            if (file_exists($userDataFile)) {
                $userData = json_decode(file_get_contents($userDataFile), true) ?? [];
                
                if (!empty($userData)) {
                    $lastEntry = end($userData);
                    
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
                    if (file_exists($userAiFile)) {
                        $aiData = json_decode(file_get_contents($userAiFile), true) ?? [];
                        if (!empty($aiData)) {
                            $latestAi = $aiData[0];
                            echo "<div class='ai-feedback'>";
                            echo "<h3>Letzte KI-Analyse:</h3>";
                            echo "<strong>Datum:</strong> " . htmlspecialchars($latestAi['timestamp']) . "<br>";
                            echo "<strong>Analyse:</strong><br>";
                            echo nl2br(htmlspecialchars($latestAi['analysis'])) . "<br>";
                            
                            if (isset($latestAi['structured_analysis'])) {
                                echo "<strong>Fitness:</strong> " . htmlspecialchars($latestAi['structured_analysis']['fitness_analysis']) . "<br>";
                                echo "<strong>Ernährung:</strong> " . htmlspecialchars($latestAi['structured_analysis']['nutrition_analysis']) . "<br>";
                                echo "<strong>Mentales:</strong> " . htmlspecialchars($latestAi['structured_analysis']['mood_analysis']) . "<br>";
                            }
                            echo "</div>";
                        }
                    }
                    
                    // Kopier-Buttons
                    echo "<h3>KI-Prompt kopieren:</h3>";
                    echo "<button class='copy-button' onclick='copyToClipboard(`" . htmlspecialchars($lastEntry['analysis_prompt']) . "`)'>Prompt kopieren</button>";
                    
                    // JSON-Daten für KI
                    $combinedData = [
                        'user_data' => $lastEntry,
                        'ai_history' => $aiData ?? []
                    ];
                    echo "<button class='copy-button' onclick='copyToClipboard(`" . htmlspecialchars(json_encode($combinedData, JSON_PRETTY_PRINT)) . "`)'>JSON kopieren</button>";
                }
            } else {
                echo "<p>Keine Daten für diesen Benutzer gefunden.</p>";
            }
        }
        ?>
    </div>
    
    <!-- JavaScript am Ende des Body-Tags -->
    <script>
    // Funktion zum Kopieren in die Zwischenablage
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('In Zwischenablage kopiert!');
        }).catch(function(err) {
            console.error('Fehler beim Kopieren:', err);
        });
    }

    // Event Listener für aufklappbare Elemente
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

        var collapsibleCells = document.getElementsByClassName("collapsible-cell");
        for (var i = 0; i < collapsibleCells.length; i++) {
            collapsibleCells[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.querySelector('.cell-content');
                content.classList.toggle("expanded");
            });
        }
    });

    // Sterne-Generator Funktion
    function createStar(e) {
        if (e.target.closest('.collapsible-cell')) {
            const star = document.createElement('div');
            star.className = 'star';
            star.style.left = e.clientX + 'px';
            star.style.top = e.clientY + 'px';
            star.textContent = ['✦', '✧', '⋆', '✫'][Math.floor(Math.random() * 4)];
            document.body.appendChild(star);

            // Entferne Stern nach Animation
            setTimeout(() => {
                star.remove();
            }, 1000);
        }
    }

    // Event Listener für Mausbewegung
    document.addEventListener('mousemove', (e) => {
        // Begrenzt die Stern-Erzeugung auf alle 100ms
        if (!document.mouseMoveThrottle) {
            document.mouseMoveThrottle = setTimeout(() => {
                document.mouseMoveThrottle = null;
                createStar(e);
            }, 100);
        }
    });
    </script>
</body>
</html>