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
            background-color: #f5ec89;
            background-image: url(http://www.transparenttextures.com/patterns/brushed-alum-dark.png);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            color: #84572f;
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
            background: #9EB1C5;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            width: 380px;
            animation: fadeIn 1.2s ease;
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

        .btn-hover {
            width: 200px;
            font-size: 16px;
            font-weight: 600;
            color: #84572f;
            cursor: pointer;
            margin: 20px;
            height: 55px;
            text-align: center;
            border: none;
            background-size: 300% 100%;
            background-color: #C5D1DF;

            border-radius: 50px;
            moz-transition: all .4s ease-in-out;
            -o-transition: all .4s ease-in-out;
            -webkit-transition: all .4s ease-in-out;
            transition: all .4s ease-in-out;
        }

        .btn-hover:hover {
            background-position: 100% 0;
            moz-transition: all .4s ease-in-out;
            -o-transition: all .4s ease-in-out;
            -webkit-transition: all .4s ease-in-out;
            transition: all .4s ease-in-out;
        }

        .btn-hover:focus {
            outline: none;
        }

        .btn-hover.color {
            background-image: linear-gradient(to right, #9EB1C5, #7f9ddf, #C5D1DF, #9EB1C5);
            box-shadow: 0 4px 15px 0 #6586cb;
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
        <h2 style="color:#84572f;">Set Up Your Face ID</h2>
        <video id="video" autoplay></video>
        <canvas id="canvas" style="display: none;"></canvas>
        <img id="preview" style="display:none;" />
        <button class="btn-hover" onclick="captureImage()">Capture Face</button>

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