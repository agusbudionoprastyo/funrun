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
