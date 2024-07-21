<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner using Instascan</title>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <style>
        /* CSS styling for video element */
        #scanner {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        /* CSS styling for result display */
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
        // Initialize Instascan
        let scanner = new Instascan.Scanner({ video: document.getElementById('scanner') });

        // Function to start scanning
        scanner.addListener('scan', function(content) {
            console.log('QR Code detected and processed:', content);
            // Display result
            document.getElementById('result').textContent = content;
            // Optionally, perform other actions based on the scanned result
            // Example: window.location.href = content;
        });

        // Start scanning when document is loaded
        document.addEventListener('DOMContentLoaded', function() {
            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                    alert('No cameras found.');
                }
            }).catch(function(e) {
                console.error('Error initializing scanner:', e);
                alert('Error initializing scanner: ' + e);
            });
        });
    </script>
</body>
</html>
