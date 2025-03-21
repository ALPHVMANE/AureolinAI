<?php
include 'C:/xampp2/htdocs/AureolinAI/env.php';
function callAPI($method, $url, $data, $headers = []) {
    $curl = curl_init();

    switch (strtoupper($method)) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if (!empty($data)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            }
            break;

        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if (!empty($data)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            }
            break;

        case "GET":
        default:
            if (!empty($data)) {
                $url = sprintf("%s?%s", $url, http_build_query($data));
            }
            break;
    }

    // Set default headers
    $defaultHeaders = [
        "X-API-Key: " . IMGGEN_APIK,
        "accept: application/json",
        "content-type: application/json"
    ];

    // Merge custom headers if provided
    if (!empty($headers) && is_array($headers)) {
        $defaultHeaders = array_merge($defaultHeaders, $headers);
    }

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_HTTPHEADER => $defaultHeaders,
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
    ]);

    // Execute cURL request
    $result = curl_exec($curl);
    $err = curl_error($curl);
    $result_string = json_encode($result);
    
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
        echo "<script>console.log('cURL Error #: $err');</script>";
        echo "<script>console.log('Error POST array: $result_string');</script>";
        return false;
    }else{
        echo $result;
        echo "<script>console.log('Error POST array: $result_string');</script>";
    }

    return json_decode($result, true);
}
?>