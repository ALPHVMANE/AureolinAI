<?php
function getImageUrl($id) {
    require_once 'C:/xampp2/htdocs/AureolinAI/config/API/imggen.ai/config.php';
    require_once 'C:/xampp2/htdocs/AureolinAI/env.php';
    // Check if IMGGEN_URL is defined
    $get_url = IMGGEN_URL . "?cursor=" .$id. "&limit=50&offset=0";
    
    // Make the API request
    $get_data = callAPI('GET', $get_url, false);
    $response = json_decode($get_data, true);

    while($response[0]['id'] !== $id) {
        echo "<script>console.log('***GET callAPI ID***: ".$response[0]['id']."');</script>";
        $response = json_decode(callAPI('GET', $get_url, false), true);
        sleep(15);
    }
    echo "<script>console.log('GET callAPI response: " .$get_data. "');</script>";
    
    // Check for errors in the response
    if (isset($response['detail']) && !empty($response['detail'])) {
        echo "<script>console.log('GET Errors: " . implode(", ", $response['detail']) . "');</script>";
        return null;
    }

    // Check if there is an image and its status
    if (isset($response[0]['id']) && isset($response[0]['images'][0])) {
        // Wait until the status is not "completed"
        while (isset($response['status']) && $response['status'] === 'completed') {
            $time = date('H:i:s');
            echo "<script>console.log('$time | Status Info:". $response['status']. "| Waiting...');</script>";
            // You might need to fetch the status again (re-request the status)
            $get_data = callAPI('GET', $get_url, false);
            $response = json_decode($get_data, true);
            sleep(30);
        }

        // After status is "completed", return the image URL
        echo "<script>document.getElementById('loading').style.display = 'none';</script>";
        if (isset($response['images']['url'])) {
            echo "<script>console.log('Image creation completed. Returning URL.".$response['images']['url']."');</script>";
            return $response['images']['url'];
        }
    }

    // Return a message if the URL is not found
    echo "<script>console.log('GET Error: URL not found in the response.');</script>";
    return null;
}
?>