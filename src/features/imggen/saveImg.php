<?php
use ImageKit\ImageKit;

$imageUrl = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    require_once '../../data/dbconfig.php';
    require_once '../../../vendor/autoload.php';
    require_once '../../../env.php';

    $imageUrl = $_POST['save'];

    // Validate URL
    if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid image URL'
        ]);
        exit;
    }

    $name = "img" . createID() . ".jpg";
    $imageKit = new ImageKit(
        UPLOAD_PubK,
        UPLOAD_PrivK,
        UPLOAD_URL
    );

    // Upload Image - URL
    $uploadFile = $imageKit->uploadFile([
        "file" => $imageUrl,
        "fileName" => $name
    ]);

    // Check for upload errors
    if ($uploadFile->error) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ImageKit upload failed: ' . $uploadFile->error->message
        ]);
        exit;
    }

    $fileId = $uploadFile->result->fileId;
    $fileUrl = $uploadFile->result->url;

    // Prepare SQL query
    global $connection;
    $sqlStmt = "INSERT INTO image_gallery (img_id, user_id, image_url) VALUES ('$fileId', NULL, '$fileUrl')";
    $queryId = mysqli_query($connection, $sqlStmt);

    if ($queryId) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Image inserted successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Insert failed: ' . mysqli_error($connection)
        ]);
    }

    mysqli_close($connection);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method or missing data'
    ]);
}

// ID Generator
function createID($file = 'last_id.txt') {
    if (!file_exists($file)) {
        file_put_contents($file, 1);
        return 1;
    }

    $lastId = (int) file_get_contents($file);
    $newId = $lastId + 1;
    file_put_contents($file, $newId);

    return $newId;
}
