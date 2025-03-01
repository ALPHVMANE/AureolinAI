<?php
session_start();
$servername = "localhost";
$username = "Tim";
$password = "admin";
$dbname = "aureolin_test";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($action === "login") {
        $stmt = mysqli_prepare($conn, "SELECT id, password FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $id, $hashed_password);
            mysqli_stmt_fetch($stmt);
            
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                header("Location: ../dashboard/dashboard.php");
                exit();
            } else {
                header("Location: ../../../public/index.php?error=Invalid password!");
                exit();
            }
        } else {
            header("Location: ../../../public/index.php?error=User not found!");
            exit();
        }
    } 
    
    elseif ($action === "signup") {
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            header("Location: ../../../public/index.php?error=Username already taken!");
            exit();
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../../../public/index.php?success=Account created! Please login.");
            } else {
                header("Location: ../../../public/index.php?error=Signup failed, try again.");
            }
            exit();
        }
    }
}
mysqli_close($conn);
?>