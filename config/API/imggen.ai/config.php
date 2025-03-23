<?php
// function callAPI($method, $url, $data, $headers = false) {
//     require_once './../env.php';
//     $curl = curl_init();

//     // Log the URL and method for debugging
//     echo "<script>console.log('Request URL: $url');</script>";
//     echo "<script>console.log('Request Method: $method');</script>";

//     // Validate $data (if provided)
//     if ($data) {
//         if (is_array($data)) {
//             $data = json_encode($data); // Convert array to JSON if necessary
//         }

//         // Log the data being sent
//         echo "<script>console.log('Request Data: " . json_encode($data) . "');</script>";

//         // Check if $data is valid JSON
//         json_decode($data);
//         if (json_last_error() != JSON_ERROR_NONE) {
//             echo "<script>console.log('Invalid JSON in request data');</script>";
//             return false;
//         }
//     }

//     // Set cURL options based on method
//     switch (strtoupper($method)) {
//         case "POST":
//             curl_setopt($curl, CURLOPT_POST, 1);
//             if ($data) 
//                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//             break;
//         default: // for GET method
//             if ($data) 
//                 $url = sprintf("%s?%s", $url, http_build_query($data));
//     }

//     // Set URL and headers
//     $defaultHeaders = array(
//         'X-IMGGEN-KEY:' . IMGGEN_APIK,
//         'Content-Type: application/json'
//     );

//     if ($headers) {
//         // Merge additional headers if provided
//         if (is_array($headers)) {
//             $headers = array_merge($defaultHeaders, $headers);
//         } else {
//             // If $headers is a single string, just append it
//             $headers[] = $headers;
//         }
//     } else {
//         // Use default headers
//         $headers = $defaultHeaders;
//     }

//     // Log headers for debugging
//     echo "<script>console.log('Request Headers: " . json_encode($headers) . "');</script>";
//     curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

//     // Set other cURL options
//     curl_setopt($curl, CURLOPT_URL, $url);
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

//     $verbose = fopen('php://temp', 'w+');  // Create a memory stream
//     curl_setopt($curl, CURLOPT_VERBOSE, true);
//     curl_setopt($curl, CURLOPT_STDERR, $verbose);  // Direct the verbose output to the memory stream
    
//     // Execute cURL request
//     $result = curl_exec($curl);
    
//     // After the request, seek the stream to the beginning and get the contents
//     rewind($verbose);
//     $verboseLog = stream_get_contents($verbose);

//     $verboseLog = str_replace(array("\n", "\r"), ' ', $verboseLog);

//     // Escape special characters for JavaScript
//     $verboseLog = addslashes($verboseLog);
    
//     // Log the verbose output for debugging
//     echo "<script>console.log('Verbose cURL output: $verboseLog');</script>";

//     // Check for cURL errors
//     if (curl_errno($curl)) {
//         echo "<script>console.log('cURL Error: " . curl_error($curl) . "');</script>";
//         return false;
//     }

//     // Get HTTP response code
//     $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//     echo "<script>console.log('HTTP Status Code: $httpCode');</script>";

//     // Decode the result
//     $err = json_decode($result, true);

//     // Close cURL
//     curl_close($curl);

//     // Error handling
//     if ($err && isset($err['success']) && $err['success'] == false) {
//         echo "<script>console.log('cURL Error #: " . $err['message'] . "');</script>";
//         echo "<script>console.log('Error POST array: $result');</script>";
//         return false;
//     } elseif ($err && isset($err['message'])) {
//         echo "<script>console.log('API Error: " . $err['message'] . "');</script>";
//         return false;
//     } else {
//         echo "<script>console.log('POST Success: $result');</script>";
//     }

//     return $result;
// }
function callAPI($method, $url, $data) {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => $method,
        CURLOPT_POSTFIELDS     => $data,
        CURLOPT_HTTPHEADER     => [
            'X-IMGGEN-KEY: ' . IMGGEN_APIK,
            'Content-Type: application/json'
        ],
        CURLOPT_VERBOSE        => true, // Enable debugging
        CURLOPT_STDERR         => fopen('php://temp', 'w+'), // Log verbose output
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if (curl_errno($curl)) {
        echo "<script>console.log('cURL Error: " . curl_error($curl) . "');</script>";
    } else {
        echo "<script>console.log('HTTP Code: " . $httpCode . "');</script>";
    }

    curl_close($curl);
    return $response;
}