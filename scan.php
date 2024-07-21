<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner with html5-qrcode</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <style>
        /* Styling for video element */
        #qr-reader-video {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 10px; /* Border radius */
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
    <video id="qr-reader-video"></video>
    <!-- Element to display scanned result -->
    <div id="result">Scanning...</div>

    <script>
        // Initialize html5-qrcode
        let html5QrCode = new Html5Qrcode('qr-reader-video');

        // Function to handle QR code detection
        function onScanSuccess(qrCodeMessage) {
            console.log('QR Code detected and processed:', qrCodeMessage);
            // Display result
            document.getElementById('result').textContent = qrCodeMessage;
            // Optionally, perform other actions based on the scanned result
            // Example: window.location.href = qrCodeMessage;
        }

        // Start scanning when document is loaded
        document.addEventListener('DOMContentLoaded', function() {
            html5QrCode.start(
                { facingMode: 'environment' }, // Use facingMode: 'environment' for back camera
                { fps: 10, qrbox: 250 }, // Optional parameters
                onScanSuccess // Callback function
            ).catch(function(err) {
                console.error('Error initializing QR Code scanner:', err);
                alert('Error initializing QR Code scanner: ' + err);
            });
        });
    </script>
</body>
</html>