<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <link rel="stylesheet" href="../templates/styleindex.css">
</head>
<body>

    <div class="circle-link" style="margin-top: -35px;">
        <a href="../templates/faceLogin.html">
            <img src="../config/images/faceid.png"alt="Face ID" style = "width:40px; height: 40px; margin-top: 5px;">
        </a>
    </div>

    <div class="glass-container">
        <div class="tabs">
            <button onclick="showTab('login')">Login</button>
            <button onclick="showTab('signup')">Signup</button>
        </div>

        <div id="login" class="tab-content active">
            <h2>Login</h2>
            <form id="loginForm" action="../src/app/auth/auth.php" method="POST">
                <input type="hidden" name="action" value="login">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>

        <div id="signup" class="tab-content">
            <h2>Signup</h2>
            <form id="signupForm" action="../src/app/auth/auth.php" method="POST">
                <input type="hidden" name="action" value="signup">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Signup</button>
            </form>
        </div>

        <div class="error">
            <?php
                if (isset($_GET['error'])) {
                    echo $_GET['error'];
                }
                if (isset($_GET['success'])) {
                    echo '<div class="success-notification">' . $_GET['success'] . '</div>';
                }
            ?>
        </div>
    </div>

    <script>
        function showTab(tab) {
            document.querySelectorAll(".tab-content").forEach(el => el.classList.remove("active"));
            document.getElementById(tab).classList.add("active");
            document.getElementById("signupForm").reset();
            document.getElementById("loginForm").reset();
        }
    </script>

</body>
</html>
