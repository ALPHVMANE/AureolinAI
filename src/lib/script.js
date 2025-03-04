const video = document.getElementById("video");
const canvas = document.getElementById("canvas");
const displaySize = { width: 600, height: 400 };

Promise.all([
  faceapi.nets.ssdMobilenetv1.loadFromUri("https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js/weights"), //detect face
  faceapi.nets.faceRecognitionNet.loadFromUri("https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js/weights"), //extract face description 
  faceapi.nets.faceLandmark68Net.loadFromUri("https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js/weights"), //detect facelandmark (eyes, nose, ...)
])
  .then(startWebcam)
  .catch((err) => {
    alert("Error loading models: " + err);
  });

function startWebcam() {
  navigator.mediaDevices
    .getUserMedia({
      video: true,
      audio: false,
    })
    .then((stream) => {
      alert("Webcam started!");
      video.srcObject = stream;
    })
    .catch((error) => {
      alert("Error starting webcam: " + error);
      console.error(error);
    });
}

// Get labeled face descriptions from images
async function getLabeledFaceDescriptions() {
  let response = await fetch("../src/data/fetch_users.php");
  let labels = await response.json();

  return Promise.all(
      labels.map(async (label) => {
          const descriptions = [];
          try {
              const imgPath = `../src/data/labels/${label}/1.png`;
              const img = await faceapi.fetchImage(imgPath);
              const detections = await faceapi
                  .detectSingleFace(img)
                  .withFaceLandmarks()
                  .withFaceDescriptor();

              if (detections) {
                  descriptions.push(detections.descriptor);
              } else {
                  console.warn(`⚠️ No face detected for user: ${label}`);
              }
          } catch (error) {
              console.warn(`⚠️ Skipping ${label}: No valid image found.`);
          }

          // Only return labeled descriptors if at least one valid face was found
          return descriptions.length > 0
              ? new faceapi.LabeledFaceDescriptors(label, descriptions)
              : null;
      })
  ).then(results => results.filter(Boolean));
}


async function loginUser(username) {
  try {
      let response = await fetch("../src/app/auth/login.php", {
          method: "POST",
          body: JSON.stringify({ username }),
          headers: { "Content-Type": "application/json" }
      });

      let data = await response.json();
      if (data.success) {
          //alert("Login successful! Redirecting...");
          window.location.href = "../src/app/dashboard/dashboard.php";
      } else {
          alert("Login failed: " + data.error);
      }
  } catch (error) {
      console.error("Login error:", error);
  }
}



// Start face detection after the video starts playing
video.addEventListener("play", async () => {
  const videoWidth = video.videoWidth;
  const videoHeight = video.videoHeight;
  if (videoWidth === 0 || videoHeight === 0) {
    alert("Invalid video dimensions.");
    return;
  }

  const labeledFaceDescriptors = await getLabeledFaceDescriptions();
  const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors);

  // Create the face tracker
  faceapi.matchDimensions(canvas, displaySize);

  setInterval(async () => {
    const detections = await faceapi
      .detectAllFaces(video)
      .withFaceLandmarks()
      .withFaceDescriptors();

    if (detections.length > 0) {
      const resizedDetections = faceapi.resizeResults(detections, displaySize);

      // Clear previous detections from canvas
      canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);

      const results = resizedDetections.map((d) => {
        return faceMatcher.findBestMatch(d.descriptor);
      });

      results.forEach((result, i) => {
        const box = resizedDetections[i].detection.box;
        const drawBox = new faceapi.draw.DrawBox(box, {
          label: result.toString(),
        });
        drawBox.draw(canvas);        
        if (result.label !== "unknown") {
          loginUser(result.label);
        }        
      });
    } else {
      console.log("No faces detected.");
    }
  }, 100);
});
