<?php
include 'database/conns.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id'])) {
        $userId = $_POST['user_id'];

        // Table and column information
        $userTable = "tb_users";
        $columnToDeleteFrom = "user_id";

        // Check if the user ID is numeric
        if (is_numeric($userId)) {
            // Prepare the SQL statement
            $sql = "DELETE FROM $userTable WHERE $columnToDeleteFrom = ?";

            // Prepare and bind the statement
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $userId); // "i" indicates the type of parameter (integer)

            // Execute the statement
            if ($stmt->execute()) {
                // If deletion is successful, send success response
                echo "success";
            } else {
                // If deletion fails, send error response
                echo "Error deleting: " . $conn->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            // If the user ID is not numeric, send an error response
            echo "Invalid user ID format";
        }
    } else {
        // If user ID is not set, send error response
        echo "Missing user ID parameter";
    }
} else {
    // If the request method is not POST, send error response
    echo "Invalid request method";
}
?>
