<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Learn a Language</title>
<link rel="stylesheet" href="../../../templates/styles/asc_style.css">
<link rel="stylesheet" href="../../../templates/styles/asc_gameStyles.css">
   <script src="../../../templates/js/UX/asc_script.js"></script>
</head>
<body>
 <?php include 'asc_navbar.php'; ?>
 <br>
 <br>
 <br>

<div class="container">
<h1>Welcome to Aureolin</h1>
<p>Select your learning language:</p>

<form action="gameQ1.php" method="POST">
<select name="language">
<option value="English">English</option>
<option value="French">French</option>
</select>
<p>Choose a difficulty</p>
        <select name="difficulty">
            <option value="beginner">Beginner</option>
            <option value="intermediate">Intermediate</option>
            <option value="expert">Expert</option>
        </select>
<button type="submit">Start Learning</button>
</form>

</div>
<?php include 'asc_footer.php'; ?>
</body>
</html>
