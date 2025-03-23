<?php
function callAPI($method, $url, $data, $headers = false) {
    require_once './../env.php';
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

    // EXECUTE
    $result = curl_exec($curl);
    $err = json_decode($result, true);
    
    curl_close($curl);

    if ($err['success'] == false || $err['success'] == null) {
        echo "<script>console.log('cURL Error #:" . $err['message'] . "');</script>";
        echo "<script>console.log('Error POST array: $result');</script>";
        return false;
    }else {
        echo "<script>console.log('POST Success: $result');</script>";
    }

    return $result;
}
?>