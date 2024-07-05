<?php
if (isset($_POST['id-image'])) {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cybervlog";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the image data from the POST request
    $idimageData = $_POST['id-image'];
    
    // Remove the data URL prefix (data:image/png;base64,)
    $idimageData = str_replace('data:image/png;base64,', '', $idimageData);
    $idimageData = str_replace(' ', '+', $idimageData);
    $idimageData = base64_decode($idimageData);

    // Get image name (for example purposes, you can modify this to use a different name)
    $idimageName = 'webcam_image_' . time() . '.png';

    // Insert the image data into the database
    $sql = "INSERT INTO id_picture (name, image) VALUES ('$idimageName', '" . addslashes($idimageData) . "')";

    if ($conn->query($sql) === TRUE) {
        echo "Image uploaded successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>

