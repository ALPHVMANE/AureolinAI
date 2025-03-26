<?php
function getImageUrl($id) {
    
    require_once 'C:\xampp2\htdocs\AureolinAI\env.php';
    // Build the URL to query the specific image by ID
    $get_url = IMGGEN_URL.$id;
    
    // Set a maximum number of attempts to prevent infinite loops
    $max_attempts = 15;
    $attempt = 0;
    
    // Headers for the API request
    $headers = [
        'X-API-Key: ' .IMGGEN_APIK,
        'accept: application/json'
    ];
    
    // Output to a specific div with ID "error-message"
    echo "<script>console.log('Starting to check status for image ID: $id');</script>\n";
    flush();
    ob_flush();
    
    while ($attempt < $max_attempts) {
        // Increment attempt counter with each loop iteration
        $attempt++;
        echo "<script>console.log('Attempt $attempt of $max_attempts');</script>\n";
        flush();
        ob_flush();
        
        // Initialize cURL session
        $curl = curl_init();
        
        // Set cURL options
        curl_setopt_array($curl, [
            CURLOPT_URL => $get_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        ]);
        
        // Execute the request
        $response_json = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        // Close cURL session
        curl_close($curl);
        
        // Check if the request was successful
        if ($http_code != 200) {
            echo "<script>console.log(GET ERROR: API request failed with HTTP code: $http_code');</script>\n";
            if ($attempt >= $max_attempts) {
                return false;
            }
            sleep(10);
            continue;
        }
        
        // Decode the JSON response
        $image_data = json_decode($response_json, true);
        echo "<script>console.log('GET response: " . json_encode($image_data) . "');</script>\n";
        
        // Check for errors in the response
        if (isset($image_data['detail']) && !empty($image_data['detail'])) {
            $error = htmlspecialchars($image_data['detail']);
            echo "<script>console.log(Error in API response: $error');</script>\n";
            return null;
        }
        
        // Get the status from the response
        $status = isset($image_data['status']) ? htmlspecialchars($image_data['status']) : 'unknown';

        echo "<script>console.log('GET Status: " . json_encode($image_data) . "');</script>\n";
        
        echo "<script>console.log('Image found! Current status: $status');</script>\n";
        
        // If image is not yet completed, wait and check again
        if ($status !== 'completed') {
            echo "<script>console.log('Current Status: $status | Waiting 15 seconds before checking again...');</script>\n";
            flush();
            ob_flush();
            sleep(15); // Wait 15 seconds before checking again
        } else {
            echo "<script>console.log('Image is complete! Returning URL.');</script>\n";
            
            // Check if the images array exists and has at least one item
            if (isset($image_data['images']) && !empty($image_data['images']) && isset($image_data['images'][0]['url'])) {
                return $image_data['images'][0]['url'];
            } else {
                echo "<script>console.log('Image is complete but URL not found in response.');</script>\n";
                return null;
            }
        }
    }
    
    // If we've reached the maximum number of attempts without success
    echo "<script>console.log('Maximum attempts reached. Image generation may have failed or timed out.');</script>\n";
    return false;
}
?>
