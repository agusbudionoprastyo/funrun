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
        #landscapeBlocker {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 10000;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        #landscapeBlocker img {
            max-width: 50%;
            max-height: 50%;
        }
    </style>
</head>
<body>
<div id="reader"></div>
<audio id="audio" src="interface.wav"></audio>
<div id="landscapeBlocker">
    <img src="block.gif" alt="Please rotate your device to portrait mode">
</div>

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

                // Send AJAX request to update status
                updateStatus(qrCodeMessage, function(success, error) {
                    if (success) {
                        // Display success result with timestamp
                        Swal.fire({
                            title: 'Fun Run',
                            html: `Check In dengan nomor BIB <b>${qrCodeMessage}</b> berhasil<br><small>${timestamp}</small>`,
                            icon: 'success',
                            timer: 10000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then(function() {
                            // Resume scanning after the alert is closed
                            scanningPaused = false;
                        });
                    } else {
                        // Display error message
                        Swal.fire({
                            title: 'Error',
                            html: `Gagal Check In untuk nomor BIB <b>${qrCodeMessage}</b><br><small>${error}</small>`,
                            icon: 'error',
                            timer: 10000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then(function() {
                            // Resume scanning after the alert is closed
                            scanningPaused = false;
                        });
                    }
                });
            }
        }

        // Function to play audio
        function playAudio() {
            audio.play().catch(function(error) {
                console.error('Error playing audio:', error);
            });
        }

        // Function to send AJAX request
        function updateStatus(bibNumber, callback) {
            fetch('update_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `bib_number=${encodeURIComponent(bibNumber)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Call callback with success = true
                    callback(true);
                } else {
                    // Call callback with success = false and error message
                    console.error('Error updating status:', data.error);
                    callback(false, data.error);
                }
            })
            .catch(error => {
                // Call callback with success = false and error message
                console.error('Error:', error);
                callback(false, error.message);
            });
        }

        // Function to start the QR code scanner with the appropriate aspect ratio
        function startQrScanner() {
            html5QrCode.start(
                { facingMode: 'environment' },
                { fps: 10, qrbox: 250, aspectRatio: 9/16 },
                onScanSuccess
            ).catch(function(err) {
                console.error('Error initializing QR Code scanner:', err);
                alert('Error initializing QR Code scanner: ' + err);
            });
        }

        // Function to show or hide the landscape blocker
        function updateLandscapeBlocker() {
            let landscapeBlocker = document.getElementById('landscapeBlocker');
            if (window.orientation === 90 || window.orientation === -90) {
                landscapeBlocker.style.display = 'flex';
                html5QrCode.stop().catch(function(err) {
                    console.error('Error stopping QR Code scanner:', err);
                });
            } else {
                landscapeBlocker.style.display = 'none';
                startQrScanner();
            }
        }

        // Start scanning when document is loaded
        document.addEventListener('DOMContentLoaded', function() {
            updateLandscapeBlocker();
        });

        // Handle orientation change
        window.addEventListener('orientationchange', function() {
            updateLandscapeBlocker();
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