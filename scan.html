<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <!-- Include QuaggaJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
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
            navigator.getUserMedia({ video: true }, function(stream) {
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

        // Initialize QuaggaJS
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#scanner')
            },
            decoder: {
                readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader", "code_39_vin_reader", "codabar_reader", "upc_reader", "upc_e_reader", "i2of5_reader", "2of5_reader", "code_93_reader"],
            }
        }, function(err) {
            if (err) {
                console.log(err);
                return
            }
            console.log("Initialization finished. Ready to start");
            Quagga.start();
        });

        // Process detected QR code
        Quagga.onDetected(function(result) {
            if (result.codeResult.code) {
                console.log("Barcode detected and processed: ", result.codeResult.code);
                // Display result
                document.getElementById("result").textContent = result.codeResult.code;
                // Stop Quagga to end scanning
                Quagga.stop();
            }
        });
    </script>
</body>
</html>
