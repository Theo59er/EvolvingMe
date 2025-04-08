<?php
// Beispiel: Abrufen von Daten vom Java-Server
$serverUrl = "http://localhost:8080/api/data";
$response = file_get_contents($serverUrl);
echo $response;
?>