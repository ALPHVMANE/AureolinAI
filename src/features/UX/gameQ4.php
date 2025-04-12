<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Quiz - Question 4</title>
    <link rel="stylesheet" href="../../../templates/styles/asc_style.css">
   <script src="../../../templates/js/UX/asc_script.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2b2e35;
            color: white;
            text-align: center;
        }
    
        .quiz-container {
            margin-top: 50px;
        }
        .image-box {
            background-color: white;
            padding: 10px;
            border-radius: 10px;
            display: inline-block;
        }
        .image-box img {
            width: 400px;
            border-radius: 10px;
        }
        .progress-bar {
            width: 50%;
            height: 5px;
            background-color: #ddd;
            margin: 20px auto;
            border-radius: 5px;
            position: relative;
        }
        .progress {
            width: 20%; /* Progress for Q1 */
            height: 5px;
            background-color: #fbc02d;
            border-radius: 5px;
        }
        .buttons {
            margin-top: 20px;
        }
        .buttons button {
            padding: 15px 30px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            font-weight: bold;
        }
        .green { background-color: #8bc34a; }
        .yellow { background-color: #ffeb3b; }
        .red { background-color: #a0522d; }
        .blue { background-color: #0288d1; }
        .white { background-color: white; }
    </style>
</head>
<body>
<?php include 'asc_navbar.php'; ?>
    

        <!-- Quiz Content -->
    <div class="quiz-container">
        <h2>4/5</h2>
        <div class="image-box">
            <img src="../../../public/images/Aureolin_Plane.jpeg" alt="Plane">
        </div>
        
        
    <div class="feedback" id="feedback"></div> <!-- Feedback placeholder -->
        <div class="buttons">
            <button class="green" onclick="wrongAnswer()">Sous-Marin</button>
            <button class="yellow" onclick="wrongAnswer()">Voiture</button>
            <button class="red" onclick="wrongAnswer()">Bateau</button>
            <button class="blue" onclick="correctAnswer()">Avion</button>
            <br>
            <button class="white" onclick="nextQuestion()">Next</button>
        </div>
    </div>

    <script>
        function nextQuestion() {
            window.location.href = "gameQ5.php";
        }

        function correctAnswer() {
            var feedback = document.getElementById('feedback');
            feedback.innerHTML = '<span style="color: green; font-size: 24px;">✅ Correct!</span>';
        }

        function wrongAnswer() {
            var feedback = document.getElementById('feedback');
            feedback.innerHTML = '<span style="color: red; font-size: 24px;">❌ Incorrect!</span>';
        }
    </script>
 <?php include 'asc_footer.php'; ?>
</body>
</html>