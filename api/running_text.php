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

// Query untuk mengambil data dari tabel Funrun
$sql_data = "SELECT DISTINCT(NAMA_GENG) FROM Funrun";
$result_data = $conn->query($sql_data);

if ($result_data->num_rows > 0) {
    // Output data dari setiap baris
    while($row = $result_data->fetch_assoc()) {
        echo "RUNNER'S " . $row["NAMA_GENG"];
    }
} else {
    echo "0 results";
}

// Menutup koneksi database
$conn->close();
?>