<?php
require_once '../env.php';
require_once '../config/API/imggen.ai/config.php';

$imageSrc = '';
$response = null;
$errors = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {

    $data = strtolower($_POST['data']);
    
    $data_array = [
        "prompt"       => "$data", 
        "aspect_ratio" => "square"
    ];

    $make_call = callAPI('POST', IMGGEN_URL, json_encode($data_array));
    
    echo "<script>console.log('$make_call');</script>";
    $response  = json_decode($make_call, true);

    if (isset($response['response']['errors'])) {
        $error = $response['response']['errors'];
        $errors = implode(", ", $error);
    } else {
        if (isset($response['images'][0])) {
            $base64Image = $response['images'][0]; 
            $imageSrc = "data:image/png;base64," . htmlspecialchars($base64Image);
        } else {
            $response = "No image found in response.";
        }
    }
    echo "<script>console.log('".json_encode($response)."');</script>";
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