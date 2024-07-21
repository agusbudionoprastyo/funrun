<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunRun</title>
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

    // Function to handle QR code detection
    function onScanSuccess(qrCodeMessage) {
        console.log('QR Code detected and processed:', qrCodeMessage);
        // Display result
        swal.fire({
            title: 'QR Code Detected',
            text: qrCodeMessage,
            icon: 'success',
            timer: 3000, // Optional, time in milliseconds after which the alert will be automatically closed
            timerProgressBar: true, // Optional, shows progress bar for the timer
            showConfirmButton: false // Optional, hides the confirm button
        });
        playAudio();
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
</body>
</html>