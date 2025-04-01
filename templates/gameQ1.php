<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Quiz - Question 1</title>
    <link rel="stylesheet" href="asc_style.css"> 
    
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
            width: 20%; 
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
        <h2>1/5</h2>
        <div class="image-box">
            <img src="./gameImages/Aureolin_House.jpeg" alt="House">
        </div>
        <div class="progress-bar">
            <div class="progress" style="width: 20%;"></div> 
        </div>
        <div class="buttons">
            <button class="green" onclick="wrongAnswer()">Cabin</button>
            <button class="yellow" onclick="correctAnswer()">House</button>
            <button class="red" onclick="wrongAnswer()">Hotel</button>
            <button class="blue" onclick="wrongAnswer()">Apartment</button>
            <br>
            <button class="white" onclick="nextQuestion()">Next</button>
           
        </div>
    </div>

    <script>
        function nextQuestion() {
            window.location.href = "gameQ2.php";
        }
        
        function correctAnswer(){
        alert("Correct Answer ✅");
        }
        
        function wrongAnswer(){
        alert("Wrong Answer ❌");
        }
    </script>
    
    <?php include 'asc_footer.php'; ?>
</body>
</html>