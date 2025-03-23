<?php
require_once '../env.php';
require_once '../config/API/imggen.ai/config.php';

$imageSrc = '';
$response = null;
$errors = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['data'])) {
    $data = trim(strtolower($_POST['data']));

    // Debugging input
    echo "<script>console.log('Prompt: " . htmlspecialchars($data, ENT_QUOTES, 'UTF-8') . "');</script>";

    $data_array = [
        "prompt"       => $data, 
        "samples"      => 1,
        "aspect_ratio" => "square",
        "model"        => "imggen-xl",
    ];

    $json_data = json_encode($data_array);

    // Debugging JSON payload
    echo "<script>console.log('JSON Payload: " . addslashes($json_data) . "');</script>";

    $make_call = callAPI('POST', IMGGEN_URL, $json_data);

    // Debugging API response
    echo "<script>console.log('POST callAPI response: " . addslashes($make_call) . "');</script>";

    $response = json_decode($make_call, true);

    if (isset($response['message'])) {
        // If 'message' is an array, join it; otherwise, just print the string
        $errors = is_array($response['message']) ? implode(", ", $response['message']) : $response['message'];
        echo "<script>console.log('Error: " . addslashes($errors) . "');</script>";
    } else {
        if (isset($response['images'][0])) {
            $base64Image = $response['images'][0]; 
            $imageSrc = "data:image/png;base64," . htmlspecialchars($base64Image);
        } else {
            echo "<script>console.log('No image found in response.');</script>";
        }
    }

    // Debugging full response
    echo "<script>console.log('Response: " . addslashes(json_encode($response)) . "');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Generator</title>
    <link rel="stylesheet" href="../templates/styles/loading.css"/>
    <link rel="stylesheet" href="../templates/styles/imggen.css"/>
    <script>
        function showLoading() {
            document.getElementById('loading').style.display = 'flex';
        }
    </script>
</head>
<body>
    <div id="imggen-container" class="imggen-container">
        <div class="imggen-content">
            <h1>AI Image Generator</h1>
            <form method="POST" action="" onsubmit="showLoading();">
                <textarea placeholder="Enter Text Prompt Here...." class="img-prompt" name="data" rows="11" cols="60" required></textarea>
                <div class="button-wrap">
                    <button type="submit">
                        <span>Generate</span>
                    </button>
                    <div class="button-shadow"></div>
                </div>
            </form>
        </div>
        <div class="img-display">
        <?php if (!empty($imageSrc)): ?>
            <img class="img-display" src="<?= $imageSrc ?>" alt="Generated Image">
            <script>document.getElementById('loading').style.display = 'none';</script>
        <?php else: ?>
            <img class="default-img img-display" src="./../public/images/defaultIMG.png" alt="Default Image">
        <?php endif; ?>

            <!-- Display Errors Below the Image -->
            <?php if (!empty($errors)): ?>
                <p style="color:red; margin-top: 10px; font-weight: bold;"><?= htmlspecialchars($errors) ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div id="loading" class="loading">
        <figure>
            <div class="loading-dot loading-white"></div>
            <div class="loading-dot"></div>
            <div class="loading-dot"></div>
            <div class="loading-dot"></div>
            <div class="loading-dot"></div>
        </figure>
  </div> 
</body>
</html>