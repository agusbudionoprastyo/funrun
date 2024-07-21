<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <!-- Include jsQR -->
    <script src="https://cdn.jsdelivr.net/npm/jsqr@2.0.1"></script>
    <style>
        /* Styling for video element */
        #scanner {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        /* Styling for result display */
        #result {
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <!-- Video element for camera feed -->
    <video id="scanner"></video>
    <!-- Element to display scanned result -->
    <div id="result">Scanning...</div>

    <script>
        // Check for getUserMedia support
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;

        if (navigator.getUserMedia) {
            // Request access to video stream
            navigator.getUserMedia({ video: { facingMode: "environment" } }, function(stream) {
                // Display video stream on the video element
                var video = document.getElementById("scanner");
                video.srcObject = stream;
                video.play();
            }, function(error) {
                console.log("Error accessing video stream:", error);
            });
        } else {
            alert("Sorry, your browser does not support video access");
        }

        // Function to process QR code
        function decodeQRFromVideo(videoElement) {
            var canvas = document.createElement('canvas');
            canvas.width = videoElement.videoWidth;
            canvas.height = videoElement.videoHeight;
            var context = canvas.getContext('2d');

            // Draw video frame onto canvas
            context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

            // Get image data from canvas
            var imageData = context.getImageData(0, 0, canvas.width, canvas.height);

            // Use jsQR library to decode QR code
            var code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: "dontInvert",
            });

            if (code) {
                console.log("QR code detected and processed:", code.data);
                // Display result
                document.getElementById("result").textContent = code.data;
                // Optionally, you can redirect or perform other actions based on the scanned result
                // Example: window.location.href = code.data;
            } else {
                console.log("No QR code detected");
            }

            // Continue scanning
            requestAnimationFrame(function() {
                decodeQRFromVideo(videoElement);
            });
        }

        // Start QR code decoding process
        document.addEventListener('DOMContentLoaded', function() {
            var video = document.getElementById("scanner");
            video.addEventListener('loadedmetadata', function() {
                decodeQRFromVideo(video);
            });
        });
    </script>
</body>
</html>