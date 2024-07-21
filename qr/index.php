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

        /* Lock orientation to portrait */
        @media (orientation: landscape) {
            body {
                transform: rotate(90deg);
                transform-origin: left bottom;
                width: 100vh;
                height: 100vw;
                overflow: hidden;
            }
        }
    </style>
</head>
<body>
<div id="reader"></div>
<audio id="audio" src="interface.wav"></audio>

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
                swal.fire({
                    title: 'Fun Run',
                    html: `Registrasi ulang dengan nomor BIB <b>${qrCodeMessage}</b> berhasil<br><small>${timestamp}</small>`,
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
                swal.fire({
                    title: 'Error',
                    html: `Gagal memperbarui status untuk nomor BIB <b>${qrCodeMessage}</b><br><small>${error}</small>`,
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

// Start scanning when document is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Start the QR code scanner
    html5QrCode.start(
        { facingMode: 'environment' },
        { fps: 10, qrbox: 250, aspectRatio: 18/9 },
        onScanSuccess
    ).catch(function(err) {
        console.error('Error initializing QR Code scanner:', err);
        alert('Error initializing QR Code scanner: ' + err);
    });
});

// Function to handle orientation change
function handleOrientationChange() {
    if (window.innerWidth > window.innerHeight) {
        // Device is in landscape mode
        document.body.style.transform = 'rotate(90deg)';
        document.body.style.transformOrigin = 'left bottom';
        document.body.style.width = '100vh';
        document.body.style.height = '100vw';
    } else {
        // Device is in portrait mode
        document.body.style.transform = '';
        document.body.style.transformOrigin = '';
        document.body.style.width = '';
        document.body.style.height = '';
    }
}

// Attach event listener to handle orientation change
window.addEventListener('resize', handleOrientationChange);

// Initial call to handle orientation on load
handleOrientationChange();
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