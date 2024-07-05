<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
    .custom-select {
        font-size: 2vh;
        height: 4.8vh;
        padding: 1vh;
        margin-top: .5vh;
        border: 0.18vw solid var(--green-pale);
        border-radius: 0.5vh;
    }    
    </style>
</head>
<body>
    <?php 
        
        include 'include/header.php';
        include 'include/sidebar.php';
        include 'database/conns.php';
    ?>    
    
    <div class="dashboard-frame">
        <div class="dashboard-title"> DASHBOARD </div>
            <div>
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

    // Fetch data from the table
    $sql = "(SELECT DISTINCT DATE_FORMAT(created_at, '%Y-%m-%d') AS date FROM tb_regular) 
            UNION 
            (SELECT DISTINCT DATE_FORMAT(created_at, '%Y-%m-%d') AS date FROM tb_vip)";; 
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<select id="options" name="options" onchange="logSelectedValueRegular()" style="width: 12%; margin-left: 7%; font-size: 14px; border: 2px solid #0E8104; border-radius: 5px;">';

        
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            // Use only created_at for the option text
            echo '<option value="' . $row["date"] . '">' . $row["date"] . '</option>';
        }
        
        echo '</select>';
    } else {  
    }
    // Close the connection
    $conn->close();
    ?>

<script>
    // JavaScript function to fetch data and log the number of rows for regular table
    async function logSelectedValueRegular() {
        var selectElement = document.getElementById('options');
        var selectedDate = selectElement.value;
        try {
            let response = await fetch(`getData.php?date=${selectedDate}`);
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            let data = await response.json();
            document.getElementById("total-reg-visitor").innerHTML = data.rowCount;
            console.log('Number of rows (Regular):', data.rowCount);
        } catch (error) {
            console.error('Fetch error:', error);
        }

        logSelectedValueVip()
    }

    // JavaScript function to fetch data and log the number of rows for VIP table
    async function logSelectedValueVip() {
        var selectElement = document.getElementById('options');
        var selectedDate = selectElement.value;
        try {
            let response = await fetch(`getDataVip.php?date=${selectedDate}`);
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            let data = await response.json();
            document.getElementById("total-vip-visitor").innerHTML = data.rowCount;
            console.log('Number of rows (VIP):', data.rowCount);
        } catch (error) {
            console.error('Fetch error:', error);
        }
    }
</script>
            </div>
        <div class="content">
            <div class="content-box">
            <span class="content-name">Total Regular Visitors</span>
                <img src="../assets/img/regular.png" alt="img">
                <span id="total-reg-visitor" class="content-name">0</span>
            </div>

            <div class="content-box">
                <span class="content-name">Total VIP Visitors</span>
                <img src="../assets/img/vip.png" alt="img">
                <span id="total-vip-visitor" class="content-name">0</span>
            </div>

            <div class="content-box">
                <span class="content-name">Overall Total Visitors</span>
                <img src="../assets/img/overall.png" alt="img">
                <span id="overall-total-visitor" class="content-name">0</span>
            </div>

        </div>
    </div>

    <script src="js/count-info-visitors.js"></script>
</body>
</html>
