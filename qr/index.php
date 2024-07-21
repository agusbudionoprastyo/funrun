<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunRun</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body>
<div id="reader" width="100%" heigh="100%"></div>
<div id="result"></div>
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
            // Optionally, perform other actions based on the scanned result
            // Example: window.location.href = qrCodeMessage;
        }

// Function to play audio
        function playAudio() {
            // Check if autoplay is allowed
            if (canAutoplay()) {
                audio.play().catch(function(error) {
                    console.error('Error playing audio:', error);
                });
            } else {
                // Show message or prompt to play audio
                showPlayButton();
            }
        }

        // Function to check if autoplay is allowed
        function canAutoplay() {
            return new Promise(function(resolve, reject) {
                let playPromise = audio.play();
                if (playPromise !== undefined) {
                    playPromise.then(function() {
                        // Autoplay is allowed
                        resolve(true);
                    }).catch(function(error) {
                        // Autoplay is not allowed
                        resolve(false);
                    });
                } else {
                    // Autoplay is not allowed
                    resolve(false);
                }
            });
        }

        // Function to show play button
        function showPlayButton() {
            document.getElementById('result').textContent = 'Tap to play sound';
            document.getElementById('result').addEventListener('click', function() {
                playAudio();
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