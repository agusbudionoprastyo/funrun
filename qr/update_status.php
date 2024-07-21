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

    // Memeriksa apakah BIB_NUMBER ada dalam tabel
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM Funrun WHERE BIB_NUMBER = ?");
    $checkStmt->bind_param('s', $bibNumber);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        // BIB_NUMBER ada, lakukan pembaruan
        $stmt = $conn->prepare("UPDATE Funrun SET status = ?, timestamp = ? WHERE BIB_NUMBER = ?");
        $stmt->bind_param('sss', $status, $timeStamp, $bibNumber);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }

        $stmt->close();
    } else {
        // BIB_NUMBER tidak ditemukan
        echo json_encode(['success' => false, 'error' => 'Nomor BIB tidak ditemukan']);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>