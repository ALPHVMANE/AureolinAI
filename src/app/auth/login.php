<?php
session_start();
include('../../data/dbconfig.php');
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$username = isset($data['username']) ? $data['username'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

if (!$username) {
    echo json_encode(["success" => false, "error" => "No username provided"]);
    exit();
}

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($connection, $sql);

if (!$stmt) {
    echo json_encode(["success" => false, "error" => "Database query preparation failed"]);
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    // Face Recognition Login (No Password Needed)
    if ($password === null) { 
        $_SESSION['username'] = $user['username'];
        echo json_encode(["success" => true]);
        exit();
    }

    // Regular Password Login
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        echo json_encode(["success" => true, "redirect" => "../dashboard/dashboard.php"]);
    } else {
        echo json_encode(["success" => false, "error" => "Invalid password"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "User not found"]);
}

mysqli_stmt_close($stmt);
mysqli_close($connection);
?>
