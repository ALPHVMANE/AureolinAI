<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "You need to log in first.";
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['image'])) {
    $username = $_SESSION['username'];
    $baseDir = '../../data/labels';
    $userDir = $baseDir . $username . '/';
    $imagePath = $userDir . '1.png';

    // Create user folder if it doesn't exist
    if (!is_dir($userDir)) {
        mkdir($userDir, 0777, true);
    }

    // Convert Base64 image to PNG file
    $imageData = explode(',', $data['image'])[1];
    $decodedImage = base64_decode($imageData);

    if (file_put_contents($imagePath, $decodedImage) === false) {
        echo "Overwriting current image";
    } else {
        echo "New image saved.";
    }    

    $servername = "localhost";
    $dbUsername = "Tim";
    $dbPassword = "admin";
    $dbname = "aureolin_test";

    $conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbname);
    if (!$conn) {
        echo "Connection failed: " . mysqli_connect_error();
        exit();
    }
    $stmt = mysqli_prepare($conn, "UPDATE users SET face_image = ? WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "ss", $imagePath, $username);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Face ID successfully set up!";
    } else {
        echo "Failed to update face ID.";
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "No image received!</br>";
}
?>
