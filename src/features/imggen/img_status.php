<?php

function getImageStatus($id) {
    require_once '../../../AureolinAI/config/API/imggen.ai/config.php';
    include '../../../AureolinAI/env.php';

    $get_url = IMGGEN_GET_URL . "?cursor=" . $id . "&limit=50&offset=0";
    $get_data = callAPI('GET', $get_url, false);

    if ($get_data === false) {
        return ['status' => 'error', 'message' => 'API request failed'];
    }

    $response = json_decode($get_data, true);
    if (isset($response['status']) && $response['status'] !== 'completed') {
        return ['status' => $response['status']];
    }

    if (isset($response['images'][0])) {
        return ['status' => 'completed', 'image_url' => $response['images'][0]['url']];
    }

    return ['status' => 'error', 'message' => 'No image found'];
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = getImageStatus($id);
    echo "<script>console.log('Status Info: " . json_encode($status) . "');</script>";
}
?>