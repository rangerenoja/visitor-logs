<?php
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
    

	function generateRow($conn){
		$contents = '';
        $sql = "SELECT * FROM tb_users";

		$query = $conn->query($sql);
		while($row = $query->fetch(PDO::FETCH_ASSOC)){
        
			$contents .= "
            <tr>
             <td>" . $row['user_id'] . "</td>
             <td>" . $row['username'] . "</td>
             <td>" . $row['fullname'] . "</td>
             <td>" . $row['serial_no'] . "</td>
             <td>" . $row['rank'] . "</td>
             <td>" . $row['unit'] . "</td>
             <td>" . $row['user_role'] . "</td>
             <td>" . $row['contact'] . "</td>
        </tr>

			";
		}

		return $contents;
	}

	require_once('../tcpdf/tcpdf.php');  
    $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('CYBER VISITOR LOG - Regular Visitors');  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 11);  
    $pdf->AddPage();  
    $content = '';  
    $content .= '
      	<h2 align="center">CYBER VISITOR LOG</h2>
        <h5 align="center"> (User Accounts)</h5>
      	<table border="1" cellspacing="0" cellpadding="3">  
           <tr>  
               <th>User ID</th><th>Username</th><th>Fullname</th><th>Serial No.</th><th>Rank</th><th>Unit</th><th>Role Type</th><th>Contact No.</th>
                
           </tr>  
      ';  
    $content .= generateRow($conn); 
    $content .= '</table>';  
    $pdf->writeHTML($content);  
    $pdf->Output('AttendanceRecords.pdf', 'I');

?>