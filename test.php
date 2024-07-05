<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>VIP Table</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
</head>
<body>

<table id="vipTable" class="table" border="1">
    <thead>
        <tr>
            <th>vip_id</th>
            <th>fullname</th>
            <th>designation</th>
            <th>position</th>
            <th>rank</th>
            <th>unit</th>
            <th>contact_no</th>
            <th>purpose_visit</th>
            <th>message</th>
            <th>signature</th>
            <th>image</th>
            <th>date</th>
            <th>time_in</th>
            <th>time_out</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Connect to your database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "cybervlog";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch data from your database table
        $sql = "SELECT vip_id, fullname, designation, position, rank, unit, contact_no, purpose_visit, message, signature, images, DATE_FORMAT(created_at, '%Y-%m-%d') AS date, TIME_FORMAT(time_in, '%H:%i:%s') AS time_in, TIME_FORMAT(time_out, '%H:%i:%s') AS time_out FROM tb_vip";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["vip_id"]."</td>";
                echo "<td>".$row["fullname"]."</td>";
                echo "<td>".$row["designation"]."</td>";
                echo "<td>".$row["position"]."</td>";
                echo "<td>".$row["rank"]."</td>";
                echo "<td>".$row["unit"]."</td>";
                echo "<td>".$row["contact_no"]."</td>";
                echo "<td>".$row["purpose_visit"]."</td>";
                echo "<td>".$row["message"]."</td>";
                echo "<td><img src='data:image/jpeg;base64,".base64_encode($row["signature"])."' style='max-width:100px'></td>";
                // Displaying the image as a link
                echo "<td><img src='data:image/jpeg;base64,".base64_encode($row["images"])."' style='max-width:100px'></td>";
                echo "<td>".$row["date"]."</td>";
                echo "<td>".$row["time_in"]."</td>";
                echo "<td>".$row["time_out"]."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='14'>0 results</td></tr>";
        }
        ?>
    </tbody>
</table>
<?php 

$sql = "SELECT reg_id, fullname, designation, position, rank, unit, contact_no, purpose_visit, DATE(created_at) AS date, TIME(time_in) AS time_in, TIME(time_out) AS time_out FROM tb_regular";

// Execute SQL query
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Fetching results as associative array
    $results = array();
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    // HTML table start
    echo "<table class='table' id='regTable' border='1'>";
    echo "<thead class='thead-dark'><tr><th>Reg ID</th><th>Full Name</th><th>Designation</th><th>Position</th><th>Rank</th><th>Unit</th><th>Contact No</th><th>Purpose of Visit</th><th>Date</th><th>Time In</th><th>Time Out</th><th>Action</th></tr></thead><tbody>";
    
    // Loop through the results array to populate the table rows
    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . $row['reg_id'] . "</td>";
        echo "<td>" . $row['fullname'] . "</td>";
        echo "<td>" . $row['designation'] . "</td>";
        echo "<td>" . $row['position'] . "</td>";
        echo "<td>" . $row['rank'] . "</td>";
        echo "<td>" . $row['unit'] . "</td>";
        echo "<td>" . $row['contact_no'] . "</td>";
        echo "<td>" . $row['purpose_visit'] . "</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "<td>" . $row['time_in'] . "</td>";
        echo "<td>" . $row['time_out'] . "</td>";
        echo '  <td>
                    <div class="dropdown-container">
                        <button class="dropdown-button">Action</button>
                        <div class="dropdown-content" style="display: none;">
                            <button data-regid="' . $row['reg_id'] . '" class="edit-button">Edit</button>
                        </div>
                    </div>
                </td>';
        echo "</tr>";
    }
    // HTML table end
    echo "</tbody></table>";
} else {
    echo "0 results";
}

// Close connection
?>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#vipTable').DataTable();
    });
</script>
</body>
</html>
