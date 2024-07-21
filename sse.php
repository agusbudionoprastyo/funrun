<?php
// sse.php

// Sertakan koneksi database
require 'qr/conn.php';

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Fungsi untuk mendapatkan data terbaru dari database
function getData() {
    global $conn; // Gunakan koneksi dari conn.php
    
    // Query untuk mengambil data dari tabel
    $sql_data = "SELECT * FROM Funrun";
    $result_data = $conn->query($sql_data);

    $data = [];
    while ($row = $result_data->fetch_assoc()) {
        $data[] = $row;
    }

    // Query untuk menghitung jumlah peserta
    $sql = "SELECT COUNT(*) AS total_peserta FROM Funrun";
    $result = $conn->query($sql);
    $total_peserta = ($result->num_rows > 0) ? $result->fetch_assoc()["total_peserta"] : 0;

    // Query untuk menghitung jumlah yang checked
    $sql_check = "SELECT COUNT(*) AS total_check FROM Funrun WHERE status = 'checked'";
    $result_check = $conn->query($sql_check);
    $total_check = ($result_check->num_rows > 0) ? $result_check->fetch_assoc()["total_check"] : 0;

    // Query untuk menghitung jumlah yang unchecked
    $sql_uncheck = "SELECT COUNT(*) AS total_uncheck FROM Funrun WHERE status = 'unchecked'";
    $result_uncheck = $conn->query($sql_uncheck);
    $total_uncheck = ($result_uncheck->num_rows > 0) ? $result_uncheck->fetch_assoc()["total_uncheck"] : 0;

    return [
        'data' => $data,
        'total_peserta' => $total_peserta,
        'total_check' => $total_check,
        'total_uncheck' => $total_uncheck
    ];
}

// Kirim data setiap beberapa detik
while (true) {
    $data = getData();
    echo "data: " . json_encode($data) . "\n\n";
    flush();

    // Tunggu beberapa detik sebelum mengirim data lagi
    sleep(10); // Sesuaikan interval sesuai kebutuhan
}
?>
