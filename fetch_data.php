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

// Pagination configuration
$items_per_page = 20; // Number of records to display per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Current page number, default is 1
$start_from = ($page - 1) * $items_per_page; // Starting index for fetching records

// Query to fetch data from database with pagination
$sql = "SELECT * FROM Funrun LIMIT $start_from, $items_per_page";
$result = $conn->query($sql);

// Check if data exists
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["NAMA_GENG"]) . "</td>"; // Replace with actual column names
        echo "<td>" . htmlspecialchars($row["BIB_NUMBER"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["status"]) . "</td>"; // Assuming 'status' is in your database
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No data found</td></tr>";
}

$conn->close();
?>