<?php 
include '../../../config/API/imggen.ai/config.php';
include '../../utils/console_debug.php';
if (defined('IMGGEN_URL')) {
    echo IMGGEN_URL."<br/>";
} else {
    echo "IMGGEN_URL is not defined. <br/>";
}
if (isset($_POST['data'])) {
    $data = strtolower($_POST['data']);
    echo $data;
    $data_array =  [
        "prompt"       => "$data", 
        "aspect_ratio" => "square"
    ];

    $make_call = callAPI('POST', IMGGEN_URL, json_encode($data_array));
    $response  = $make_call;

    // Check if there were any errors in the response
    if (isset($response['response']['errors'])) {
        $errors = $response['response']['errors'];
        echo "Errors: " . implode(", ", $errors);
    } else {
        // Handle the success case
        if (isset($response['images'][0])) {
            $base64Image = $response['images'][0]; // Extract the base64-encoded image
            
            // Display the image using a data URL
            echo "<h3>Generated Image:</h3>";
            echo "<img src='data:image/png;base64, " . htmlspecialchars($base64Image) . "' alt='Generated Image' />";
        } else {
            echo "<br/> No image found in response.";
        }
    }
    // debugging
    console_debug($response);
} else {
    echo json_encode(['errors' => ['No data provided.']]);
}
?>