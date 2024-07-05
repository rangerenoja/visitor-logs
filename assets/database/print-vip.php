<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<table class="table" id="vipTable" border="1">
    <thead class="thead-dark">
        <tr>
            <th>Vip_id</th>
            <th>Fullname</th>
            <th>Designation/Position</th>
            <th>Rank</th>
            <th>Unit</th>
            <th>Contact_no</th>
            <th>Purpose_visit</th>
            <th>Signature</th>
            <th>Image</th>
            <th>ID Name</th>
            <th>ID Picture</th>
            <th>Date</th>
            <th>Time in</th>
            <th>Time out</th>
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
        $sql = "SELECT vip_id, fullname, designation, rank, unit, contact_no, purpose_visit, signature, images, id_name, id_picture, DATE_FORMAT(created_at, '%Y-%m-%d') AS date, TIME_FORMAT(time_in, '%H:%i:%s') AS time_in, TIME_FORMAT(time_out, '%H:%i:%s') AS time_out FROM tb_vip";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["vip_id"]."</td>";
                echo "<td>".$row["fullname"]."</td>";
                echo "<td>".$row["designation"]."</td>";
                echo "<td>".$row["rank"]."</td>";
                echo "<td>".$row["unit"]."</td>";
                echo "<td>".$row["contact_no"]."</td>";
                echo "<td>".$row["purpose_visit"]."</td>";
                echo "<td><img src='data:image/jpeg;base64,".base64_encode($row["signature"])."' style='max-width:100px'></td>";
                // Displaying the image as a link
                echo "<td><img src='data:image/jpeg;base64,".base64_encode($row["images"])."' style='max-width:100px'></td>";
                echo "<td>".$row["id_name"]."</td>";
                echo "<td><img src='data:image/jpeg;base64,".base64_encode($row["id_picture"])."' style='max-width:100px'></td>";
                echo "<td>".$row["date"]."</td>";
                echo "<td>".$row["time_in"]."</td>";
                $time_out_display = ($row['time_out'] == '00:00:00') ? 'TBD' : $row['time_out'];
                echo "<td>" . $time_out_display . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='14'>0 results</td></tr>";
        }
        $conn->close();
        ?>
    </tbody>
</table>


<script>
        // When the page is fully loaded including graphics
        window.onload = function() {
            window.print();
        }
    </script>