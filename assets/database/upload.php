<!-- <?php
if(isset($_POST['upload'])) {
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

    // Get image name and image data
    $name = $conn->real_escape_string($_POST['name']);
    $image = $_FILES['image']['tmp_name'];
    $imgContent = addslashes(file_get_contents($image));

    // Insert image data into the database
    $sql = "INSERT INTO images (name, image) VALUES ('$name', '$imgContent')";

    if ($conn->query($sql) === TRUE) {
        echo "Image uploaded successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?> -->

<?php
if (isset($_POST['image'])) {
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
    $imageData = $_POST['image'];
    
    // Remove the data URL prefix (data:image/png;base64,)
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);
    $imageData = base64_decode($imageData);

    // Get image name (for example purposes, you can modify this to use a different name)
    $imageName = 'webcam_image_' . time() . '.png';

    // Insert the image data into the database
    $sql = "INSERT INTO images (name, image) VALUES ('$imageName', '" . addslashes($imageData) . "')";

    if ($conn->query($sql) === TRUE) {
        echo "Image uploaded successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>

