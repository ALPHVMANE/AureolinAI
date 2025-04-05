<?php
// header("Content-Type: application/json");
use ImageKit\ImageKit;  

$imageUrl = "";
// Check if the image URL is sent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
// if(isset($_POST['save'])) {
    require_once '../../data/dbconfig.php';
    require_once '../../../vendor/autoload.php';
    require_once '../../../env.php';

    $imageUrl = $_POST['save'];

    // Validate URL
    if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
        // echo "<script>console.log('ERROR url: Invalid image URL');</script>";
        exit;
    }

    $name = "img".createID().".jpg";
    $imageKit = new ImageKit(
        UPLOAD_PubK,
        UPLOAD_PrivK,
        UPLOAD_URL
    );

    // Upload Image - URL
    $uploadFile = $imageKit->uploadFile([
        "file" => "$imageUrl",
        "fileName" => "$name"
    ]);

    $fileId = $uploadFile->result->fileId;
    $fileUrl = $uploadFile->result->url;

    // echo "<script>console.log('Upload URL: " . json_encode($uploadFile) . "'); </script>";


    // Prepare SQL query
    global $connection;
    $img_id = createID();
    $sqlStmt = "INSERT INTO image_gallery (img_id, user_id, image_url) VALUES ('$fileId', NULL, '$fileUrl')";
    $queryId = mysqli_query($connection, $sqlStmt);

    if ($queryId) {
        // echo "<script>console.log('SUCCESS: Image inserted successfully');</script>";
        return json_encode(['status' => 'success', 'message' => 'Image inserted successfully']);
    } else {
        // echo "<script>console.log('ERROR Query:'Insert failed: '" . mysqli_error($connection) . ");</script>";
        return json_encode(['status' => 'error', 'message' => 'Insert failed: ' . mysqli_error($connection)]);
    }

    mysqli_close($connection);
} else {
    // echo "<script>console.log('ERROR server: Invalid request method or missing data');</script>";
    return json_encode(['status' => 'error', 'message' => 'Invalid request method or missing data']);
}

function createID($file = 'last_id.txt') {
    // If the file doesn't exist, create it with initial ID of 1
    if (!file_exists($file)) {
        file_put_contents($file, 1);
        return 1;
    }

    // Get the last ID
    $lastId = (int) file_get_contents($file);

    // Increment the ID
    $newId = $lastId + 1;

    // Save the new ID back to the file
    file_put_contents($file, $newId);

    return $newId;
}