<?php
require_once "env.php";
function generateImage($prompt, $aspect_ratio = "square") {
    $apiKey = IMGGEN_APIK;
    $url = IMGGEN_URL;

    $data = json_encode([
        "prompt" => $prompt,
        "aspect_ratio" => $aspect_ratio
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "X-IMGGEN-KEY: $apiKey",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo "cURL error: " .curl_error($ch);
    }
    curl_close($ch);

    return json_decode($response, true);
}



$result = generateImage("close up photo of a rabbit");

if ($result && isset($result['image_url'])) {
    echo "<img src='" . htmlspecialchars($result['image_url']) . "' alt='Generated Image'>";
} else {
    echo "Failed to generate image.";
}
?>
