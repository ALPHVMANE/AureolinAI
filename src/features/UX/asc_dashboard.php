<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aureolin - Home</title>
    <link rel="stylesheet" href="templates/css/asc_style.css">
    
    <style>
        body {
            display: center; 
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #2b2e35;
        }
        .form-container {
            width: 300px;
            height: 300px;
            background-color: #7DB3F2;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        input, button {
            margin: 10px;
            padding: 10px;
            width: 80%;
        }
        button {
            background-color: #ffcc00;
            color: black;
            border: none;
            cursor: pointer;
        }
        .center-div {
            display: flex;
            justify-content: center; /* Centers horizontally */
            align-items: center; /* Centers vertically */
            height: 100vh; /* Takes full viewport height */
        }
        
        .search-container {
            text-align: center;
            margin: 20px auto;
        }

        .search-container label {
            font-size: 22px;
            font-weight: bold;
            color: #AFC1D6;
            display: block;
            margin-bottom: 8px;
        }

        .search-container input {
            width: 300px;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        /* Leaderboard */
        .leaderboard {
            text-align: center;
            margin-top: 20px;
        }

        .leaderboard h2 {
            font-size: 24px;
            color: #AFC1D6;
        }

        .top-3 {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
        }

        .player {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #444;
            padding: 15px;
            border-radius: 10px;
            width: 120px;
        }

        .player img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        .player p {
            font-size: 22px;
            font-weight: bold;
            margin: 5px 0;
        }

        .player h3 {
            font-size: 16px;
            margin: 5px 0;
            color: white;
        }

        .player span {
            font-size: 18px;
            font-weight: bold;
            color: #FFD700;
        }
        
    </style>
    
</head>
<body>
    <?php include 'asc_navbar.php'; ?>  <!-- Include the reusable nav bar -->
    
    <div class="search-container">
        <label for="search">Learn a language</label>
        <input type="text" id="search" placeholder="Search">
    </div>

    <!-- Leaderboard -->
    <div class="leaderboard">
        <h2>LEADERBOARD</h2>
        <div class="top-3">
            <div class="player second">
                <img src="./users/xenon.png" alt="Xenon Fitch">
                <p>2</p>
                <h3>Xenon Fitch</h3>
                <span>12.6</span>
            </div>
            <div class="player first">
                <img src="./users/eiden.png" alt="Eiden Blues">
                <p>1</p>
                <h3>Eiden Blues</h3>
                <span>18.7</span>
            </div>
            <div class="player third">
                <img src="./users/gemma.png" alt="Gemma Vu">
                <p>3</p>
                <h3>Gemma Vu</h3>
                <span>16.7</span>
            </div>
        </div>
    </div>
 <?php include 'asc_footer.php'; ?> 
</body>
</html>