<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../../public/index.php?error=Please login first!");
    exit();
}
?> 
<!--ASSUME THE USER HAS ROOM TEMP IQ-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Up Face ID</title>
</head>
<body>
    <h2>Face ID Setup</h2>
    <video id="video" width="320" height="240" autoplay></video>
    <canvas id="canvas" style="display: none;"></canvas>
    <button onclick="captureImage()">Capture Face</button>
    <p id="status"></p>

    <script>
        // Start webcam
        const video = document.getElementById('video');
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => { video.srcObject = stream; })
            .catch(err => { console.error("Error accessing webcam:", err); });

        function captureImage() {
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Convert image to Base64
            const imageData = canvas.toDataURL('image/png');

            // Send image to backend
            fetch('capture_face.php', {
                method: 'POST',
                body: JSON.stringify({ image: imageData }),
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => response.text())
            .then(data => { document.getElementById('status').innerText = data; })
            .catch(error => { console.error('Error:', error); });
        }
    </script>
</body>
</html>
