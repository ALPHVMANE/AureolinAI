<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Learn a Language</title>
<link rel="stylesheet" href="/WEBAPPPROJECT/templates/styles/asc_style.css">
<link rel="stylesheet" href="/WEBAPPPROJECT/templates/styles/asc_gameStyles.css">
   <script src="/WEBAPPPROJECT/templates/js/asc_script.js"></script>
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
<option value="Spanish">Spanish</option>
<option value="French">French</option>
<option value="German">German</option>
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
