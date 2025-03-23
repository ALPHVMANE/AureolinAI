<?php  
require_once '../config/API/imggen.ai/config.php';


$response = null; // Initialize response variable
$errors = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {

    $data = strtolower($_POST['data']);
    echo "<script>console.log('Data input:', " . json_encode($data) . ");</script>";

    $data_array = [
        "prompt" => "$data",  // This is where the user's input goes
        "aspect_ratio" => "square",
        "highResolution" => false,
        "images" => 1,
        "steps" => 20,
        "initialImageMode" => "color"
    ];

    $make_call = callAPI('POST', IMGGEN_URL, json_encode($data_array));
    $response  = $make_call;
    $r_string = json_encode($response);

    echo "<script>console.log('Check make_call response: ". json_encode($response)."');</script>'";

    if (isset($response['detail']) && is_array($response['detail'])) {
        // Convert error details into a string if it's an array
        $errors = json_encode($response['detail'], JSON_PRETTY_PRINT);
        echo "<script>console.error('imgGen.php Error:', " . json_encode($errors) . ");</script>";
    } else {
        if (isset($response['images'][0])) {
            $base64Image = $response['images'][0]; 
            $response = "<img src='data:image/png;base64," . htmlspecialchars($base64Image) . "' alt='Generated Image' />";
        } else {
            $errors = "No image found in response.";
            echo "<script>console.error('imgGen.php Error:', " . json_encode($errors) . ");</script>";
        }
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
    </script>
</head>
<body>
    <div id="imggen-container" class="imggen-container">
        <div class="imggen-content">
            <h1>AI Image Generator</h1>
            <form method="POST" action="" onsubmit="showLoading()">
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
        <?= $response ? '<img class="img-display" src="' . $response . '" alt="Generated Image">' : '<img class="default-img img-display" src="../public/images/default_imggen.png" alt="Default Image">' ?>
        <?php if (!empty($errors)): ?>
                <p style="color:red; margin-top: 10px; font-weight: bold;"><?= htmlspecialchars($errors) ?></p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>