<?php  
require_once '../config/API/imggen.ai/config.php';

$response = null; 
$errors = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
    $data = strtolower($_POST['data']);

    $data_array = [
        "prompt" => $data,
        'model' => 'lyra',
        "aspect_ratio" => "square",
        "highResolution" => false,
        "images" => 1,
        "steps" => 20,
        "initialImageMode" => "color"
    ];

    $make_call = callAPI('POST', IMGGEN_URL, json_encode($data_array));
    error_log(json_encode($make_call));

    if (isset($response_data['detail']) && is_array($response_data['detail'])) {
        // Extract readable error messages
        $errors = implode(", ", array_column($response_data['detail'], 'msg'));
    } elseif (isset($response_data['images'][0])) {
        $base64Image = $response_data['images'][0]; 
        $response = "data:image/png;base64," . htmlspecialchars($base64Image);
    } else {
        $errors = "No image found in response.";
    }
}
?>