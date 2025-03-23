<?php  
require_once '../config/API/imggen.ai/config.php';
include '../src/features/imggen/img_get.php';

$response = null; 
$errors = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
    $data = strtolower($_POST['data']);
    $data_array = [
        "prompt" => $data,
        'model' => 'lyra',
        "aspect_ratio" => "square",
        "highResolution" => false,
        "images" => 1,
        "steps" => 20,
        "initialImageMode" => "color"
    ];

    $make_call = callAPI('POST', IMGGEN_URL, json_encode($data_array));
    echo "<script>console.log('POST Response: " . $make_call . "');</script>";
    $response_data = json_decode($make_call, true);

    if (isset($response_data['detail']) && is_array($response_data['detail'])) {
        $errors = implode(", ", array_column($response_data['detail'], 'msg'));
    } elseif (isset($response_data['images'])) {
        echo "<script>document.body.style.background = blue;</script>";
        set_time_limit(300);
        echo "<script>console.log('getImageUrl ID: " . json_encode($response_data['id']) . "'); </script>";
        $response = getImageUrl($response_data['id']);
        echo "<script>console.log('IMAGE URL response: " . $response . "');document.getElementById('loading').style.display = 'none';</script>";
        if ($response === null) {
            $errors = "GET error: Image generation failed.";
            echo "<script>document.getElementById('loading').style.display = 'none';</script>";
        }
    } else {
        $errors = "No image found in response.";
    }
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
        function hideLoading() {
            document.getElementById('loading').style.display = 'none';
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
            <?php if ($response || $response !== null): ?>
                <img class="img-display" src="<?= $response ?>" alt="Generated Image">
            <?php else: ?>
                <img class="default-img img-display" src="../public/images/default_imggen.png" alt="Default Image">
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