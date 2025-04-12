<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../../public/index.php?error=Please login first!");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Set Up Face ID</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: rgb(253, 255, 150);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            width: 380px;
            animation: fadeIn 1.2s ease;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        video,
        #preview {
            border-radius: 12px;
            border: 2px solid #ccc;
            width: 100%;
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
            animation: fadeIn 1s ease;
        }

        button {
            margin-top: 15px;
            padding: 12px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        #status {
            margin-top: 15px;
            color: green;
            min-height: 20px;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s ease;
            z-index: 999;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <button class="back-btn" onclick="goBack()">← Back</button>
    <div class="container">
        <h2>Set Up Your Face ID</h2>
        <video id="video" autoplay></video>
        <canvas id="canvas" style="display: none;"></canvas>
        <img id="preview" style="display:none;" />
        <button onclick="captureImage()">Capture Face</button>

        <p id="status"></p>
    </div>

    <script>
        const video = document.getElementById('video');
        const preview = document.getElementById('preview');

        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                console.error("Error accessing webcam:", err);
                document.getElementById('status').innerText = 'Could not access webcam.';
            });

        function goBack() {
            window.history.back();
        }

        function captureImage() {
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = canvas.toDataURL('image/png');

            // Show captured preview
            preview.src = imageData;
            preview.style.display = 'block';
            document.getElementById('status').innerText = 'Uploading face...';

            fetch('capture_face.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        image: imageData
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('status').innerText = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('status').innerText = 'Something went wrong.';
                });
        }
    </script>
</body>

</html>