<?php
// Assuming you have a MySQL database connection
$servername = "localhost";
$username = "dafm5634_ag";
$password = "Ag7us777__";
$dbname = "dafm5634_funrun";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data
$sql = "SELECT * FROM Funrun'";
$result = $conn->query($sql);

// Initialize variables for search and counts
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$total_peserta = 0;
$total_check = 0;
$total_uncheck = 0;

// Query to fetch data based on search term
$sql_search = "SELECT * FROM Funrun WHERE NAMA_GENG LIKE '%$searchTerm%' OR BIB_NUMBER LIKE '%$searchTerm%' OR status LIKE '%$searchTerm%'";
$result_search = $conn->query($sql_search);

if (!$result_search) {
    die("Query failed: " . $conn->error);
}

// Query to fetch total number of participants
$sql_total = "SELECT COUNT(*) AS total_peserta FROM Funrun";
$result_total = $conn->query($sql_total);

if ($result_total) {
    $row_total = $result_total->fetch_assoc();
    $total_peserta = $row_total["total_peserta"];
} else {
    die("Query failed: " . $conn->error);
}

// Query to fetch number of participants checked
$sql_checked = "SELECT COUNT(*) AS total_check FROM Funrun WHERE status = 'checked'";
$result_checked = $conn->query($sql_checked);

if ($result_checked) {
    $row_checked = $result_checked->fetch_assoc();
    $total_check = $row_checked["total_check"];
} else {
    die("Query failed: " . $conn->error);
}

// Query to fetch number of participants unchecked
$sql_unchecked = "SELECT COUNT(*) AS total_uncheck FROM Funrun WHERE status = 'unchecked'";
$result_unchecked = $conn->query($sql_unchecked);

if ($result_unchecked) {
    $row_unchecked = $result_unchecked->fetch_assoc();
    $total_uncheck = $row_unchecked["total_uncheck"];
} else {
    die("Query failed: " . $conn->error);
}

// Close database connection
$conn->close();
?>
