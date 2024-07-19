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

        // Query to fetch data for table
        $sql_data = "SELECT * FROM Funrun";
        $result_data = $conn->query($sql_data);

        // Query to fetch counts
        $sql = "SELECT COUNT(*) AS total_peserta FROM Funrun";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total_peserta = $row["total_peserta"];
        } else {
            $total_peserta = 0;
        }

        // Query to fetch counts for check and uncheck (assuming 'status' column indicates checked or unchecked)
        $sql_check = "SELECT COUNT(*) AS total_check FROM Funrun WHERE status = 'checked'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            $row_check = $result_check->fetch_assoc();
            $total_check = $row_check["total_check"];
        } else {
            $total_check = 0;
        }

        $sql_uncheck = "SELECT COUNT(*) AS total_uncheck FROM Funrun WHERE status = 'unchecked'";
        $result_uncheck = $conn->query($sql_uncheck);

        if ($result_uncheck->num_rows > 0) {
            $row_uncheck = $result_uncheck->fetch_assoc();
            $total_uncheck = $row_uncheck["total_uncheck"];
        } else {
            $total_uncheck = 0;
        }

$conn->close();
?>
