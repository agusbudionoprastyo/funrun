<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunRun</title>
    <link rel="manifest" href="./manifest.json">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
    </style>
</head>
<body>
<div id="reader"></div>
<audio id="audio" src="beep.wav"></audio>
  <script>
    // Initialize
    let html5QrCode = new Html5Qrcode('reader');
    let audio = document.getElementById('audio');
    let scanningPaused = false;

    // Function to handle QR code detection
    function onScanSuccess(qrCodeMessage) {
        if (!scanningPaused) {
            console.log('QR Code detected and processed:', qrCodeMessage);
            // Pause scanning
            scanningPaused = true;
            playAudio();
            // Get current timestamp
            let timestamp = new Date().toLocaleString();

            // Display result with timestamp
            swal.fire({
                title: 'Fun Run',
                html: `Registrasi ulang dengan nomor BIB <b>${qrCodeMessage}</b> berhasil<br><small>${timestamp}</small>`,
                icon: 'success',
                timer: 10000, // Optional, time in milliseconds after which the alert will be automatically closed
                timerProgressBar: true, // Optional, shows progress bar for the timer
                showConfirmButton: false // Optional, hides the confirm button
            }).then(function() {
                // Resume scanning after the alert is closed
                scanningPaused = false;
            });
        }
    }

    // Function to play audio
    function playAudio() {
        audio.play().catch(function(error) {
            console.error('Error playing audio:', error);
        });
    }

    // Start scanning when document is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Start the QR code scanner
        html5QrCode.start(
            { facingMode: 'environment' }, // Use facingMode: 'environment' for back camera
            { fps: 10, qrbox: 250, aspectRatio: 18/9 }, // Optional parameters
            onScanSuccess // Callback function
        ).catch(function(err) {
            // Catch any errors that occur during initialization
            console.error('Error initializing QR Code scanner:', err);
            alert('Error initializing QR Code scanner: ' + err);
        });
    });
</script>

<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('./service-worker.js').then(function(registration) {
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
                console.error('ServiceWorker registration failed: ', err);
            });
        });
    }
</script>

</body>
</html>