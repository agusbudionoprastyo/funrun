// update_status.php
<?php
// Menyertakan file koneksi
include 'conn.php';

// Memeriksa apakah data POST diterima
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bibNumber = $_POST['bib_number'];
    $timeStamp = $_POST['timestamp'];
    $status = 'checked';

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Mengupdate status berdasarkan bib_number
    $stmt = $conn->prepare("UPDATE funrun SET status, timestamp = ? WHERE bib_number = ?");
    $stmt->bind_param('sss', $status, $timeStamp $bibNumber);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>