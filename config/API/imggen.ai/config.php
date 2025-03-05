<?php
require_once "env.php";

function callAPI($method, $url, $data) {
    $curl = curl_init();
    switch (strtoupper($method)) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data) 
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data) 
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // OPTIONS:   curl_setopt($curl, CURLOPT_URL, $url);   curl_setopt($curl, CURLOPT_HTTPHEADER, array(      'APIKEY: 111111111111111111111',      'Content-Type: application/json',   ));   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);   // EXECUTE:   $result = curl_exec($curl);   if(!$result){die("Connection Failure");}   curl_close($curl);   return $result;}
}
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
