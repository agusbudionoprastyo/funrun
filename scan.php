<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunRun</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body>
<div id="reader" width="600px"></div>
<div id="result"></div>
    <script>
        // Initialize html5-qrcode
        let html5QrCode = new Html5Qrcode('reader');

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