<?php  
require_once '../config/API/imggen.ai/config.php';
include '../src/features/imggen/img_get.php';

$response = null; 
$errors = ''; 
$find_id = null;

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
        set_time_limit(300);
        echo "<script>console.log('getImageUrl ID: " . json_encode($response_data['id']) . "'); </script>";
        $find_id = getImageUrl($response_data['id']);
        

        echo "<script>console.log('IMAGE URL response: " . $find_id . "');</script>";

        if ($find_id === null) {
            $errors = "GET error: Image generation failed.";
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
    <link rel="stylesheet" href="../templates/styles/asc_navbar.css"/>
    <link rel="stylesheet" href="../templates/styles/loading.css"/>
    <link rel="stylesheet" href="../templates/styles/imggen.css"/>
</head>
<body>
    <div id="loading" class="loading">
        <figure>
            <div class="loading-dot loading-white"></div>
            <div class="loading-dot"></div>
            <div class="loading-dot"></div>
            <div class="loading-dot"></div>
            <div class="loading-dot"></div>
        </figure>
    </div> 
    <?php include '../src/features/UX/asc_navbar.php'; ?>
    <div id="imggen-container" class="imggen-container">
        <div class="imggen-content">
            <h1>AI Image Generator</h1>
            <form method="POST" action="" onsubmit="showLoading();">
                <textarea placeholder="Enter Text Prompt Here...." class="img-prompt" name="data" rows="11" cols="60" required></textarea>
                <div class="button-wrap">
                    <button type="submit" class="btn-hover color">Generate</button>
                        <script>
                            const imageUrl = "<?= $find_id ?>"; // Pass the PHP $find_id to JavaScript as imageUrl
                            console.log('Generated Image URL:', imageUrl); // You can check if it's being passed correctly
                        </script>
                    <button type="button" class="btn-hover color" name="save" id="saveBtn" onclick="saveImage(imageUrl);">
                        <span>Save</span>
                    </button>
                </div>
            </form>
        </div>
        <div class="img-display">
            <?php if ($find_id || $find_id !== null): ?>
                <img class="img-display" src="<?= $find_id ?>" alt="Generated Image">
                <script> 
                    document.getElementById('loading').style.display = 'none'; 
                </script>
                
            <?php else: ?>
                <img class="default-img img-display" src="../public/images/defaultIMG.png" alt="Default Image">
            <?php endif; ?>

            <!-- Display Errors Below the Image -->
            <?php if (!empty($errors)): ?>
                <p style="color:red; margin-top: 10px; font-weight: bold;"><?= htmlspecialchars($errors) ?></p>
                <script> document.getElementById('loading').style.display = 'none'; </script>
            <?php endif; ?>
        </div>
    </div>
    <script>
        function showLoading() {
            document.getElementById('loading').style.display = 'flex';
        }

        function saveImage(imgUrl) {
            console.log(imgUrl);
            if (!imgUrl || imgUrl.includes('defaultIMG.png')) {
                alert("No image to save!");
                return;
            }

            let formData = new FormData();
            formData.append("save", imgUrl);

            fetch('../src/features/imggen/saveImg.php', {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    console.log(data.message);
                    alert("Image saved successfully");
                } else {
                    console.error(data.message);
                    alert("Error saving image: " + data.message);
                }
            })
            .catch(error => console.error("Fetch Error:", error));
        }
    </script>
</body>
</html>
