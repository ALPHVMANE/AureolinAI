<?php 
require_once 'C:\xampp2\htdocs\AureolinAI\env.php';

// image_proxy.php
header('Content-Type: application/json');
sleep(30);

// Get the image ID from the request - add isset check
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo json_encode(['error' => 'No image ID provided']);
    exit;
}

// API endpoint
$url = IMGGEN_URL . $id;

// Initialize cURL
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'X-API-Key: '. IMGGEN_APIK,
        'Accept: application/json'
    ]
]);

// Execute request
$response = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Return the API response with the same status code
http_response_code($status_code);
echo $response;
?>