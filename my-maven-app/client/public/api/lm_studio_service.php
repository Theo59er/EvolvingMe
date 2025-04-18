<?php
date_default_timezone_set('Europe/Berlin');

class LMStudioService {
    private $apiUrl = 'http://127.0.0.1:1234/v1/chat/completions';
    
    public function generateAnalysis($content, $name, $previousAnalysis) {
        // Lade AI-Verlauf
        $aiHistory = $this->loadAiHistory($name);
        
        $data = [
            'model' => 'mistral-nemo-instruct-2407',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Du bist ein hilfreicher Assistent für Selbstreflexion. Analysiere den Text basierend auf vorherigen Analysen und strukturiere deine Antwort in: 1. Tagesübersicht 2. Ernährung 3. Fitness 4. Mentales Wohlbefinden 5. Empfehlungen'
                ],
                [
                    'role' => 'user',
                    'content' => "Vorherige Analyse:\n$previousAnalysis\n\nNeue Notizen:\n$content"
                ]
            ]
        ];

        try {
            $opts = [
                'http' => [
                    'method' => 'POST',
                    'header' => [
                        'Content-Type: application/json',
                        'Connection: keep-alive'
                    ],
                    'content' => json_encode($data),
                    'timeout' => 30,
                    'ignore_errors' => true
                ]
            ];

            $context = stream_context_create($opts);
            $response = file_get_contents($this->apiUrl, false, $context);
            
            if ($response === false) {
                throw new Exception('Keine Antwort von LM Studio erhalten');
            }

            $result = json_decode($response, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Ungültige JSON-Antwort: ' . json_last_error_msg());
            }

            $analysis = $result['choices'][0]['message']['content'] ?? 'Keine Analyse verfügbar.';
            
            return [
                'success' => true,
                'analysis' => $analysis
            ];

        } catch (Exception $e) {
            error_log('LM Studio Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function loadAiHistory($name) {
        $safeName = preg_replace('/[^a-z0-9]/i', '_', strtolower($name));
        $aiFile = __DIR__ . '/../data/' . $safeName . '_ai.json';
        
        if (file_exists($aiFile)) {
            return json_decode(file_get_contents($aiFile), true) ?? [];
        }
        return [];
    }
}

// Handle API request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'] ?? '';
    $name = $_POST['name'] ?? '';
    $previousAnalysis = $_POST['previous_analysis'] ?? '';
    
    $service = new LMStudioService();
    header('Content-Type: application/json');
    echo json_encode($service->generateAnalysis($content, $name, $previousAnalysis));
}
?>