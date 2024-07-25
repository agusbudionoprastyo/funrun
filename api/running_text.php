<?php
// Informasi koneksi database
$servername = "localhost";
$username = "dafm5634_ag";
$password = "Ag7us777__";
$dbname = "dafm5634_funrun";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data NAMA_GENG dari tabel Funrun
$sql_data = "SELECT DISTINCT(NAMA_GENG) FROM Funrun";
$result_data = $conn->query($sql_data);

$runnerNames = [];
if ($result_data->num_rows > 0) {
    // Memasukkan data ke dalam array $runnerNames
    while($row = $result_data->fetch_assoc()) {
        $runnerNames[] = $row["NAMA_GENG"];
    }
} else {
    echo "0 results";
}

// Menutup koneksi database
$conn->close();

// Mengirimkan data dalam format JSON
echo json_encode($runnerNames);
?>