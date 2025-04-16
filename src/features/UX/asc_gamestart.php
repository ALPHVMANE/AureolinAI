<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Learn a Language</title>

  <!-- Navbar Styling -->
  <link rel="stylesheet" href="../../../templates/styles/asc_navbar.css" />
  <script src="../../../templates/js/UX/asc_script.js"></script>

  <style>
    body.gamestart-page {
      font-family: 'Poppins', sans-serif;
      background-color: #ddd498;
      color: #84572f;
      margin: 0;
      padding: 0;
    }

    .gamestart-container {
      min-height: calc(100vh - 160px); /* Adjust for navbar/footer */
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .gamestart-container .container {
      width: 100%;
      max-width: 600px;
      background-color: #9EB1C5;
      color: #84572f;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      padding: 40px;
      text-align: center;
    }

    .gamestart-container h1 {
      font-size: 2rem;
      margin-bottom: 15px;
    }

    .gamestart-container p {
      margin-bottom: 10px;
      font-weight: 500;
    }

    .gamestart-container select {
      padding: 8px 12px;
      font-size: 1rem;
      border-radius: 6px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
      color: #84572f;
    }

    .gamestart-container button {
      background-color: #ddd498;
      color: #84572f;
      font-weight: bold;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .gamestart-container button:hover {
      background-color: #C5D1DF;
    }
  </style>
</head>
<body class="gamestart-page">
  <?php include 'asc_navbar.php'; ?>
  <br><br><br>

  <div class="gamestart-container">
    <div class="container">
      <h1>Welcome to Aureolin</h1>
      <p>Select your learning language:</p>

      <form action="gameQ1.php" method="POST">
        <select name="language" required>
          <option value="" disabled selected>Select a language</option>
          <option value="English">English</option>
          <option value="French">French</option>
        </select>

        <p>Choose a difficulty</p>
        <select name="difficulty" required>
          <option value="" disabled selected>Select difficulty</option>
          <option value="beginner">Beginner</option>
          <option value="intermediate">Intermediate</option>
          <option value="expert">Expert</option>
        </select>

        <br><br>
        <button type="submit">Start Learning</button>
      </form>
    </div>
  </div>

  <?php include 'asc_footer.php'; ?>
</body>
</html>