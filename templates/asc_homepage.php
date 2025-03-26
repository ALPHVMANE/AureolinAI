<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aureolin - Home</title>
    <link rel="stylesheet" href="asc_style.css">
    
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
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
        }
        
    </style>
    
</head>
<body>
    <?php include 'asc_navbar.php'; ?>  
    
    <div class="center-div">
    <div class="form-container">
        <h2>Welcome to Aureolin</h2>
        <p>Pick a language</p>
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
        <button>start a game</button>
    </div>
</div>
    
</body>
</html>