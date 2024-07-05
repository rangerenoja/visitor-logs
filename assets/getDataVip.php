<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "cybervlog"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data based on the date passed through GET parameter
$date = $_GET['date']; // Get the selected date from the URL parameter
$sql = "SELECT COUNT(*) AS rowCount FROM tb_vip WHERE DATE(created_at) LIKE '$date'";
$result = $conn->query($sql);

// Fetch data and convert it to JSON
$data = null;

if ($result->num_rows > 0) {
    // Fetch the result row
    $row = $result->fetch_assoc();
    $data = $row["rowCount"];
} else {
    $data = 0;
}

// Close the connection
$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode(array('rowCount' => $data));
?>
