<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "cybervlog";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['edit'])) {
    // Retrieve form data
    $id = $_POST['edit-id'];
    $fullname = $_POST['edit-fullname'];
    $serial_no = $_POST['edit-serial_no'];
    $role_type = $_POST['edit-role_type'];
    $username = $_POST['edit-username'];
    $user_contact = $_POST['edit-user_contact'];
    if(empty($_POST['edit-reg-rank-text'])){
        $rank = $_POST['edit-rank'];
       
       }else {
           $rank = $_POST['edit-reg-rank-text'];
           
       }
    $unit = $_POST['edit-unit'];

    // Update query
    $sql = "UPDATE tb_users SET 
            fullname = '" . $fullname . "', 
            serial_no = '" . $serial_no . "', 
            user_role = '" . $role_type . "', 
            username = '" . $username . "', 
            contact = '" . $user_contact . "', 
            rank = '" . $rank . "', 
            unit = '" . $unit . "' 
            WHERE user_id = " . $id;

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully'); window.location.href='users.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
