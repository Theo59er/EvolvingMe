<?php
function getLMStudioAnalysis($content) {
    $apiUrl = 'http://192.168.31.71:1234/v1/chat/completions';
    
    $data = [
        'messages' => [
            [
                'role' => 'system',
                'content' => 'Du bist ein hilfreicher Assistent für Selbstreflexion. Analysiere den folgenden Text und gib konstruktives Feedback in maximal 3 Sätzen.'
            ],
            [
                'role' => 'user',
                'content' => $content
            ]
        ],
        'temperature' => 0.7,
        'max_tokens' => 150,
        'model' => 'gpt-3.5-turbo' // oder das Modell, das Sie in LM Studio geladen haben
    ];

    try {
        $ch = curl_init($apiUrl);
        if ($ch === false) {
            throw new Exception('Curl initialization failed');
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        
        if ($response === false) {
            throw new Exception(curl_error($ch));
        }
        
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new Exception("HTTP Error: $httpCode - $response");
        }

        $result = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response: ' . json_last_error_msg());
        }

        return [
            'success' => true,
            'analysis' => $result['choices'][0]['message']['content'] ?? 'Keine Analyse verfügbar.'
        ];

    } catch (Exception $e) {
        error_log('LM Studio Error: ' . $e->getMessage());
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}

// Handle request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'] ?? '';
    header('Content-Type: application/json');
    echo json_encode(getLMStudioAnalysis($content));
}
?>