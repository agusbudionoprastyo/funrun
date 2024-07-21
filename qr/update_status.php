<?php
// Menyertakan file koneksi
include 'conn.php';

// Memeriksa apakah data POST diterima
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bibNumber = $_POST['bib_number'];
    $timeStamp = date('Y-m-d H:i:s'); // Membuat timestamp di sisi server
    $status = 'checked';

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'error' => 'Koneksi gagal: ' . $conn->connect_error]);
        exit();
    }

    // Mengupdate status dan timestamp berdasarkan bib_number
    $stmt = $conn->prepare("UPDATE Funrun SET status = ?, timestamp = ? WHERE bib_number = ?");
    $stmt->bind_param('sss', $status, $timeStamp, $bibNumber);

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