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
        set_time_limit(300);
        echo "<script>console.log('getImageUrl ID: " . json_encode($response_data['id']) . "'); </script>";
        // $response = getImageUrl($response_data['id']);
        // while (isset($response_data['status']) && $response_data['status'] === 'completed') {
        //     $time = date('H:i:s');
        //     echo "<script>console.log('$time | Status Info:". $response['status']. "| Waiting...');</script>";
        //     // You might need to fetch the status again (re-request the status)
        //     $get_data = callAPI('GET', $get_url, false);
        //     $response_data = json_decode($get_data, true);
        //     sleep(30);
        // }
        // while (isset($response_data['status']) && $response_data['status'] !== 'completed') {
        //     echo '<meta http-equiv="refresh" content="30">';
        //     $get_data = callAPI('GET', $get_url, false);
        //     $response_data = json_decode($get_data, true);
        // }
        $get_url = IMGGEN_URL . "?cursor=" .$response_data['id']. "&limit=50&offset=0";
        if (isset($_GET['check_status'])) {
            $get_data = callAPI('GET', $get_url, false);
            echo "<script>console.log('GET Response: " . $get_data . "');</script>"; 
            echo $get_data;
            exit();
        }
        
        $response = $response_data['images'][0]['url'];

        echo "<script>console.log('IMAGE URL response: " . $response . "');</script>";

        if ($response === null) {
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
                <script> document.getElementById('loading').style.display = 'none'; </script>
            <?php else: ?>
                <img class="default-img img-display" src="../public/images/default_imggen.png" alt="Default Image">
            <?php endif; ?>

            <!-- Display Errors Below the Image -->
            <?php if (!empty($errors)): ?>
                <p style="color:red; margin-top: 10px; font-weight: bold;"><?= htmlspecialchars($errors) ?></p>
                <script> document.getElementById('loading').style.display = 'none'; </script>
            <?php endif; ?>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        checkStatus('<?php echo $response_data['id']; ?>');
        });

        var IMGGEN_URL = "<?php echo IMGGEN_URL; ?>";   

        function showLoading() {
            document.getElementById('loading').style.display = 'flex';
        }
        function checkStatus(imageId) {
        fetch(`${IMGGEN_URL}?cursors=${imageId}&limit=50&offset=0`)  // Add image_id as a query parameter
        .then(response => {
            console.log('Fetch Response:', response);  // Log the response object
            return response.json();
        })
        .then(data => {
            console.log('Response Data:', data);  // Log the parsed JSON data
            if (data.status === 'completed') {
                console.log("Image is ready!");
                location.reload();  // Reload the page when the image is ready
            } else {
                console.log("Waiting for completion...");
                setTimeout(() => checkStatus(imageId), 30000);  // Check again in 30 seconds
            }
        })
        .catch(error => console.error("Error fetching status:", error));
}


// Assuming you have an imageId to check:
        checkStatus('<?php echo $response_data['id']; ?>');
    </script>
</body>
</html>