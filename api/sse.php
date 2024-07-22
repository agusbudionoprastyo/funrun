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

    // Query untuk mengambil fastest_checkin
    $sql_fastest_checkin = "SELECT NAMA_GENG, last_timestamp
    FROM (
        SELECT NAMA_GENG, timestamp AS last_timestamp,
            ROW_NUMBER() OVER (PARTITION BY NAMA_GENG ORDER BY timestamp ASC) AS row_num
        FROM Funrun
        WHERE status = 'checked'
    ) AS ranked
    WHERE row_num >= 5;";
 
    $result_fastest_checkin = $conn->query($sql_fastest_checkin);
 
    $fastest_checkin = [];
    while ($row = $result_fastest_checkin->fetch_assoc()) {
        $fastest_checkin[] = $row;
    }
 
    // Query untuk mendapatkan max timestamp dari data yang statusnya 'checked'
    $sql_max_timestamp = "SELECT MAX(timestamp) AS max_timestamp, NAMA_GENG, BIB_NUMBER FROM Funrun WHERE status = 'checked'";
    $result_max_timestamp = $conn->query($sql_max_timestamp);
    $max_timestamp = ($result_max_timestamp && $result_max_timestamp->num_rows > 0) ? $result_max_timestamp->fetch_assoc()["max_timestamp"] : null;
 
     // Query untuk menghitung jumlah peserta
     $sql = "SELECT COUNT(*) AS total_peserta FROM Funrun";
     $result = $conn->query($sql);
     $total_peserta = ($result && $result->num_rows > 0) ? $result->fetch_assoc()["total_peserta"] : 0;
 
     // Query untuk menghitung jumlah yang checked
     $sql_check = "SELECT COUNT(*) AS total_check FROM Funrun WHERE status = 'checked'";
     $result_check = $conn->query($sql_check);
     $total_check = ($result_check && $result_check->num_rows > 0) ? $result_check->fetch_assoc()["total_check"] : 0;
 
     // Query untuk menghitung jumlah yang unchecked
     $sql_uncheck = "SELECT COUNT(*) AS total_uncheck FROM Funrun WHERE status = 'unchecked'";
     $result_uncheck = $conn->query($sql_uncheck);
     $total_uncheck = ($result_uncheck && $result_uncheck->num_rows > 0) ? $result_uncheck->fetch_assoc()["total_uncheck"] : 0;
 
     return [
         'fastest_checkin' => $fastest_checkin,
         'max_timestamp_checked' => $max_timestamp,
         'total_peserta' => $total_peserta,
         'total_check' => $total_check,
         'total_uncheck' => $total_uncheck
     ];
 } 

 // Kirim data setiap beberapa detik
while (true) {
    $data = getData($conn);
    echo "data: " . json_encode($data) . "\n\n";
    ob_flush(); // Pastikan output buffer dikirim ke browser
    flush();    // Pastikan output dikirim ke browser

    // Tunggu beberapa detik sebelum mengirim data lagi
    sleep(10); // Sesuaikan interval sesuai kebutuhan
}

// Tutup koneksi (meskipun ini tidak akan pernah dieksekusi dalam loop tak berujung)
$conn->close();
?>
