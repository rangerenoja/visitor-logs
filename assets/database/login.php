<?php

session_start();
if (isset($_SESSION['username'])) {
    header("Location: ../dashboard.php"); // Redirect to dashboard if already logged in
    exit;
}




// Database connection parameters
$host = 'localhost'; // Assuming your database is hosted locally
$dbname = 'cybervlog';
$username = 'root';
$password = '';

// Attempt to connect to the database
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO to throw exceptions on errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // If connection fails, display error message
    echo "Connection failed: " . $e->getMessage();
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM tb_users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Fetch the password from the database
            $db_password = $row['password'];
            
            // Compare the input password with the password from the database
            if ($password === $db_password) {
                // Passwords match, redirect to dashboard
                $_SESSION['username'] = $username;
                header("Location: ../dashboard.php");
                exit;
            } else {
                // Password is incorrect
                $_SESSION['error'] = "Incorrect password";
                header("Location: ../../index.php");
            }
        } else {
            // Username doesn't exist
            $_SESSION['error'] = "Username not found";
            header("Location: ../../index.php");

        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
