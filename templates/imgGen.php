<?php  
include '../config/API/imggen.ai/config.php';
include '../src/utils/console_debug.php';

$response = null; // Initialize response variable

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
    $data = strtolower($_POST['data']);
    
    $data_array = [
        "prompt"       => "$data", 
        "aspect_ratio" => "square"
    ];

    $make_call = callAPI('POST', IMGGEN_URL, json_encode($data_array));
    $response  = $make_call;

    if (isset($response['response']['errors'])) {
        $errors = $response['response']['errors'];
        $response = "<p style='color: red;'>" . implode(", ", $errors) . "</p>";
    } else {
        if (isset($response['images'][0])) {
            $base64Image = $response['images'][0]; 
            $response = "<img src='data:image/png;base64," . htmlspecialchars($base64Image) . "' alt='Generated Image' />";
        } else {
            $response = "<p>No image found in response.</p>";
        }
    }
    console_debug($response);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Generator</title>
    <link rel="stylesheet" href="../templates/styles/imggen_style.css" />
    <link rel="stylesheet" href="../templates/styles/loading.css" />
    <script>
        function showLoading() {
            document.getElementById('loading').style.display = 'flex';
        }
    </script>
</head>
<body>
    <div id="imggen-container" class="imggen-container">
        <div id="loading" class="loading" style="display: none;">
            <figure>
                <div class="loading-dot loading-white"></div>
                <div class="loading-dot"></div>
                <div class="loading-dot"></div>
                <div class="loading-dot"></div>
                <div class="loading-dot"></div>
            </figure>
        </div>
        <div class="imggen-content">
            <h1>AI Image Generator</h1>
            <form method="POST" action="" onsubmit="showLoading()">
                <textarea placeholder="Enter Text Prompt Here...." id="prompt" name="data" rows="11" cols="60" required></textarea>
                <div class="button-wrap">
                    <button type="submit">
                        <span>Generate</span>
                    </button>
                    <div class="button-shadow"></div>
                </div>
            </form>
        </div>
        <div id="img-display">
            <?= $response ?? '' ?>
        </div>
    </div>
</body>
</html>