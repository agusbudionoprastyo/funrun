// sse.php

<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Koneksi ke database
$servername = "localhost";
$username = "dafm5634_ag";
$password = "Ag7us777__";
$dbname = "dafm5634_funrun";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk mendapatkan data terbaru dari database
function getData($conn) {
    // Query untuk mendapatkan NAMA_GENG yang telah dicentang (checked)
    $sql_nama_geng = "SELECT DISTINCT NAMA_GENG FROM Funrun";
    $result_nama_geng = $conn->query($sql_nama_geng);

    $footer_text = '';

    if ($result_nama_geng && $result_nama_geng->num_rows > 0) {
        while ($row = $result_nama_geng->fetch_assoc()) {
            $footer_text .= $row['NAMA_GENG'] . ' | '; // Format teks yang sesuai dengan kebutuhan running text
        }
        // Hilangkan '|' di akhir
        $footer_text = rtrim($footer_text, ' | ');
    }

    return [
        'footer_text' => $footer_text
    ];
}

// Kirim data setiap beberapa detik
while (true) {
    $data = getData($conn);
    echo "data: " . json_encode($data) . "\n\n";
    ob_flush();
    flush();
    sleep(10); // Sesuaikan interval sesuai kebutuhan
}

// Tutup koneksi (meskipun ini tidak akan pernah dieksekusi dalam loop tak berujung)
$conn->close();
?>