<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunRun</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        #reader {
            width: 100%;
            height: 100%;
        }

        #audio {
            display: none; /* Hide audio element */
        }
    </style>
</head>
<body>
<div id="reader"></div>
<div id="result">Result will appear here</div>
<audio id="audio" src="beep.wav"></audio>
<script>
    // Initialize
    let html5QrCode = new Html5Qrcode('reader');
    let audio = document.getElementById('audio');

    // Function to handle QR code detection
    function onScanSuccess(qrCodeMessage) {
        console.log('QR Code detected and processed:', qrCodeMessage);
        // Display result
        document.getElementById('result').textContent = qrCodeMessage;
        playAudio()
    }

    // Function to play audio
    function playAudio() {
        // Check if autoplay is allowed
        audio.play().catch(function(error) {
            console.error('Error playing audio:', error);
        });
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
