<?php
include '../../../env.php';
function callAPI($method, $url, $data, $headers = false) {
    $curl = curl_init();
    switch (strtoupper($method)) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data) 
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        // case "PUT":
        //     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        //     if ($data)
        //         curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //     break;
        default: // for GET method
            if ($data) 
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
     // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   if(!$headers){
       curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'X-IMGGEN-KEY: '.IMGGEN_APIK,
          'Content-Type: application/json',
       ));
   }else{
       curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'X-IMGGEN-KEY: '.IMGGEN_APIK,
          'Content-Type: application/json',
          $headers
       ));
   }
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    // Execute request
    $result = curl_exec($curl);
        
    if (!$result) {
        die("Connection Failure: " . curl_error($curl));
    }
    curl_close($curl);

    return json_decode($result, true);
}