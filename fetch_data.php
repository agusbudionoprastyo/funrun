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

// Query to fetch data from database
$sql = "SELECT * FROM funrun";
$result = $conn->query($sql);

// Check if data exists
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["NAMA_GENG"] . "</td>"; // Replace with actual column names
        echo "<td>" . $row["BIB_NUMBER"] . "</td>";
        echo "<td><span class='status'>" . $row["status"] . "</span></td>"; // Assuming 'status' is in your database
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No data found</td></tr>";
}
$conn->close();
?>
