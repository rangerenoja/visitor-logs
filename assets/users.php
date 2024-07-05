    <?php 
include 'include/header.php';
include 'include/sidebar.php';
include 'database/conns.php';
?>

<?php


if (isset($_SESSION['alert_message'])) {
    echo '<script>alert("' . $_SESSION['alert_message'] . '");</script>';
    unset($_SESSION['alert_message']); 
}


include 'database/conns.php';
$roleType = "";


$sql = "SELECT user_role FROM tb_users WHERE username = ?";
$stmt = $conn->prepare($sql);


$stmt->bind_param("s", $_SESSION['username']);


$stmt->execute();


$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $roleType = $row['user_role'];
    echo '<script>console.log("Role: ' . $roleType . '");</script>';
} else {
    echo '<script>console.log("User not found.");</script>';
}

$stmt->close();


if($roleType == "User"){
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <style>
             .popup-edit-reg {
        display:none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999; /* Adjust z-index as needed */
    background-color: white; /* Set background color */
    border: 1px solid black; /* Add border */
    padding: 20px; /* Add padding */
    border-radius: 5px; /* Add border radius */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add box shadow */
}

.checkbox-container {
  display: flex;
  align-items: center;
  height: 15%;

}

.checkbox-label {
    margin-left: 5px;
    margin-top: 10px;
}
    </style>

</head>



<body>
    <div class="visitors-frame">
        <div class="first">
            <div class="visitors-title"> USERS </div>
            <div class="addUser-btn" id="addUser">
                <span class="addUser-btn-text"> Add User </span>
            </div>
        </div>
        

        <div class="table1">
            <div class="guestType">
                <span class="table1-title"> Type of Guest </span>
                <div class="guest-dropdown-container">
                    <div class="guestType-button"> 
                        <span class="guest-box-text"> User </span>
                    </div>
                </div>
            </div>   
            <div class="container9">
                <div class="addGuest-btn" onclick="printUser()">
                    <span class="addGuest-btn-text"> Print</span>
                </div>
            </div>     
        </div>

        <div class="users-table-container p-3" style="display: block;">
            <?php 
                $sql = "SELECT * FROM tb_users";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $results = array();
                    while ($row = $result->fetch_assoc()) {
                        $results[] = $row;
                    }
                    echo "<table class='table' id='regTable' border='1'>";
                    echo "<thead class='thead-dark'><tr><th>User ID</th><th>Username</th><th>Fullname</th><th>Serial No.</th><th>Rank</th><th>Unit</th><th>Role Type</th><th>Contact No.</th><th>Action</th></tr></thead><tbody>";

                    foreach ($results as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['fullname'] . "</td>";
                        echo "<td>" . $row['serial_no'] . "</td>";
                        echo "<td>" . $row['rank'] . "</td>";
                        echo "<td>" . $row['unit'] . "</td>";
                        echo "<td>" . $row['user_role'] . "</td>";
                        echo "<td>" . $row['contact'] . "</td>";
                        echo '  <td>
                                    <div class="dropdown-container">
                                        <button class="dropdown-button">Action</button>
                                        <div class="dropdown-content" id="editDown" style="display: none; ; z-index: 1000;">
                                            <button data-usergid="' . $row['user_id'] . '" class="edit-button">Edit</button>
                                            <button class="reg-delete-button" delete-data-usergid="' . $row['user_id'] . '">Delete</button>
                                        </div>
                                    </div>
                                </td>';
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "0 results";
                }
                $conn->close();
            ?>
        </div>
    </div>


    
    <div class="popup" id="popup">
        <div class="popup-content">
            <div class="popup-title">Add User</div>
            <div id="alert-container"></div>
                <div id="user_input_container" class="input-container">
                    <form class="input-container" id="addUserForm" method="POST" action="add_user.php" enctype="multipart/form-data">
                    <div class="text-input-container" >
                        <div class="inputs">
                            <div>
                                <div class="label"> Personnel Name </div>
                                <input type="textbox" class="textbox" name="fullname">
                            </div>
                        </div>

                        <div class="inputs">
                            <div>
                                <div class="label"> Serial No. </div>
                                <input type="textbox" class="textbox" name="serial_no">
                            </div>
                        </div>

                    


                        <div class="selects">
                            <label for="role_type">Role Type<br> </label>
                            <select id="role_type" name="role_type">
                                <option value="User">User</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>


                        <div class="inputs">
                            <div>
                                <div class="label"> Username </div>
                                <input type="textbox" class="textbox" name="username">
                            </div>
                        </div>
                    
                    
                </div>

                <div class="text-input-container">

                    <div class="inputs">
                        <div>
                            <div class="label"> Contact no: </div>
                            <input type="number" class="textbox" name="user_contact">
                        </div>
                    </div>
                    <div class="inputs">
    <div>
        <div class="label"> Rank: </div>
        <div class="checkbox-container">
            <input type="checkbox" id="edit-reg-rank-others" onchange="toggleEditRegInput()"> <!-- Checkbox for others -->
            <label class="checkbox-label">Others/Specify</label>
        </div>
        <div class="selects" id="edit-reg-rank-select"> <!-- Select input -->
            <select id="edit-reg-rank" name="edit-rank">
            <option value="Private">Ms.</option>
            <option value="Private">Mr.</option>
                            <option value="Private">Private</option>
                            <option value="Private first class">Private first class</option>
                            <option value="Corporal">Corporal</option>
                            <option value="Sergeant">Sergeant</option>
                            <option value="Staff sergeant">Staff Sergeant	</option>
                            <option value="Technical sergeant">Technical Sergeant</option>
                            <option value="Master sergeant">Master Sergeant</option>
                            <option value="Senior master sergeant">Senior Master Sergeant</option>
                            <option value="Chief master sergeant">Chief Master Sergeant</option>
                            <option value="Second lieutenant">Second Lieutenant</option>
                            <option value="First lieutenant">First Lieutenant</option>
                            <option value="Captain">Captain</option>
                            <option value="Major">Major</option>
                            <option value="Lieutenant Colonel">Lieutenant Colonel</option>
                            <option value="Colonel">Colonel</option>
                            <option value="Brigadier general">Brigadier General</option>
                            <option value="	Major general">Major General</option>
                            <option value="Lieutenant general">Lieutenant General</option>
                            <option value="General">General</option>
            </select>
        </div>
        <input type="text" id="edit-reg-rank-text" class="textbox" name="edit-reg-rank-text" style="display: none;"> <!-- Text input, initially hidden -->
    </div>
</div>


                    <div class="inputs" style="margin-top: -15%">
                        <div>
                            <div class="label"> Unit </div>
                            <input type="textbox" class="textbox" name="unit">
                        </div>
                    </div>

                    <div class="inputs">
                        <div>
                            <div class="label"> Password </div>
                            <input type="password" class="textbox" name="password">
                        </div>
                    </div>

                </div>

                
           
            </div>
        
            <div class="popup-button-container">
                <button type="submit" name="add" id="add-visitor-btn"> Add User</button>
                <div data-dismiss="popup" id="cancel"> Cancel</div>
            </div>
            </form>
        </div>
    </div>


            <script>
                  function toggleEditRegInput() {
    var checkBox = document.getElementById("edit-reg-rank-others");
    var selectInput = document.getElementById("edit-reg-rank-select");
    var textInput = document.getElementById("edit-reg-rank-text");

    if (checkBox.checked) {
        selectInput.style.display = "none";
        textInput.style.display = "block";
    } else {
        selectInput.style.display = "block";
        textInput.style.display = "none";
    }
}
function toggleEditUserInput() {
    var checkBox = document.getElementById("edit-user-rank-others");
    var selectInput = document.getElementById("edit-user-rank-select");
    var textInput = document.getElementById("edit-user-rank-text");

    if (checkBox.checked) {
        selectInput.style.display = "none";
        textInput.style.display = "block";
    } else {
        selectInput.style.display = "block";
        textInput.style.display = "none";
    }
}
            </script>

    <!-- Popup for Edit -->
    <div class="popup-edit-reg" id="popup-edit">
    <div class="popup-content">
        <div class="popup-title">Edit User</div>
     
        <div id="alert-container"></div>
        <div id="user_input_container" class="input-container">
            <form class="input-container" id="editUserForm" method="POST" action="save-user.php" enctype="multipart/form-data">
            <input type="hidden" name="edit-id"id="edit-id" >
                <div class="text-input-container">
                    <div class="inputs">
                        <div>
                            <div class="label"> Personnel Name </div>
                            <input type="textbox" class="textbox" name="edit-fullname">
                        </div>
                    </div>

                    <div class="inputs">
                        <div>
                            <div class="label"> Serial No. </div>
                            <input type="textbox" class="textbox" name="edit-serial_no">
                        </div>
                    </div>

                    <div class="selects">
                        <label for="edit-role_type">Role Type<br> </label>
                        <select id="edit_role_type" name="edit-role_type">
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <div class="inputs">
                        <div>
                            <div class="label"> Username </div>
                            <input type="textbox" class="textbox" name="edit-username">
                        </div>
                    </div>
                </div>

                <div class="text-input-container">
                    <div class="inputs">
                        <div>
                            <div class="label"> Contact no: </div>
                            <input type="number" class="textbox" name="edit-user_contact">
                        </div>
                    </div>

                    <div class="inputs">
    <div>
        <div class="label">Rank:</div>
        <div class="checkbox-container">
            <input type="checkbox" id="edit-user-rank-others" onchange="toggleEditUserInput()">
            <label class="checkbox-label">Others/Specify</label>
        </div>
        <div class="selects" id="edit-user-rank-select">
            <select id="edit-user-rank" name="edit-rank">
                <option value="Ms.">Ms.</option>
                <option value="Mr.">Mr.</option>
                <option value="Private">Private</option>
                <option value="Private first class">Private first class</option>
                <option value="Corporal">Corporal</option>
                <option value="Sergeant">Sergeant</option>
                <option value="Staff sergeant">Staff sergeant</option>
                <option value="Technical sergeant">Technical sergeant</option>
                <option value="Master sergeant">Master sergeant</option>
                <option value="Senior master sergeant">Senior master sergeant</option>
                <option value="Chief master sergeant">Chief master sergeant</option>
                <option value="Second lieutenant">Second lieutenant</option>
                <option value="First lieutenant">First lieutenant</option>
                <option value="Captain">Captain</option>
                <option value="Major">Major</option>
                <option value="Lieutenant Colonel">Lieutenant Colonel</option>
                <option value="Colonel">Colonel</option>
                <option value="Brigadier general">Brigadier general</option>
                <option value="Major general">Major general</option>
                <option value="Lieutenant general">Lieutenant general</option>
                <option value="General">General</option>
            </select>
        </div>
        <input type="text" id="edit-user-rank-text" class="textbox" name="edit-reg-rank-text" style="display: none;">
    </div>
</div>




                    <div class="inputs">
                        <div>
                            <div class="label"> Unit </div>
                            <input type="textbox" class="textbox" name="edit-unit">
                        </div>
                    </div>

                    <!-- <div class="inputs">
                        <div>
                            <div class="label"> Password </div>
                            <input type="textbox" class="textbox" name="edit-password">
                        </div>
                    </div> -->
                </div>
           
        </div>

        <div class="popup-button-container">
            <button type="submit" name="edit" id="edit-user-btn"> Edit User</button>
            <div data-dismiss="popup-edit-reg" id="cancel-edit"> Cancel</div>
        </div>

        </form>
    </div>
</div>







    <script>
  // JavaScript for user delete button
document.querySelectorAll('.reg-delete-button').forEach(button => {
    button.addEventListener('click', function() {
        const userId = this.getAttribute('delete-data-usergid');
        // Send AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_user.php'); // Ensure this URL is correct
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = xhr.responseText;
                if (response.trim() === 'success') {
                    alert('User deleted successfully');
                    window.location.reload(); // Reload the page after successful deletion
                } else {
                    alert('Failed to delete user: ' + response);
                }
            } else {
                alert('Error: ' + xhr.statusText);
            }
        };
        xhr.send('user_id=' + encodeURIComponent(userId));
    });
});

       

        function printUser(){
            window.open("./database/print-user.php");
        }
       
         document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addUser').addEventListener('click', function() {
            document.getElementById('popup').classList.add('show');
            });
         });

         document.getElementById('add-visitor-btn').addEventListener('click', function() {
   
        var inputs = document.querySelectorAll(' #addUserForm input[type=number], #addUserForm select');

    
        var isEmpty = false;

    
        inputs.forEach(function(input) {
            if (input.value.trim() === '') {
                isEmpty = true;
            }
        });

    
        if (isEmpty) {
            var alertMessage = '<div class="alert alert-danger" role="alert">Please fill in all fields.</div>';
            document.getElementById('alert-container').innerHTML = alertMessage;
            event.preventDefault(); 

            setTimeout(function() {
            document.getElementById('alert-container').innerHTML = '';
        }, 2000);
        }else {
        document.getElementById('alert-container').innerHTML = ''; // Clear previous alert

        
    }
    });

    var dropdownButtons = document.querySelectorAll('.dropdown-button');
   


    dropdownButtons.forEach(function(dropdownButton) {
            dropdownButton.addEventListener('click', function() {
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === 'none' || dropdownContent.style.display === '') {
                    dropdownContent.style.display = 'block';
                } else {
                    dropdownContent.style.display = 'none';
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.edit-button');
    var popup = document.querySelector('.popup-edit-reg');

    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            popup.style.display = 'block'; // Show the popup'
            document.getElementById("editDown").style.display = 'none';


            var regId = this.getAttribute('data-usergid');
            console.log(regId);

            fetch('fetch_user_data.php?id=' + regId)
            .then(response => response.json())
            .then(data => {
    // Process the fetched data
    console.log(data);
    document.getElementById("edit-id").value = regId;
    // Update input fields with fetched data
  
    document.querySelector('input[name="edit-fullname"]').value = data.fullname || '';
    document.querySelector('input[name="edit-serial_no"]').value = data.serial_no || '';
    document.querySelector('input[name="edit-username"]').value = data.username || '';
    document.querySelector('input[name="edit-user_contact"]').value = data.contact;
    document.querySelector('select[name="edit-rank"]').value = data.rank || '';
    document.querySelector('input[name="edit-unit"]').value = data.unit || '';
    document.querySelector('input[name="edit-password"]').value = data.password || '';

    // Set role_type only if it's defined
    if (data.role_type !== undefined) {
        document.querySelector('select[name="edit-role_type"]').value = data.role_type;
    }
})

            .catch(error => console.error('Error fetching data:', error));


        });
    });
});


        var cancelButton = document.getElementById('cancel-edit');
        cancelButton.addEventListener('click', function() {
            document.getElementById("popup-edit").style.display = 'none'; // Hide the popup
    });


        document.getElementById('cancel').addEventListener('click', function() {
            document.getElementById('popup').classList.remove('show');
        });

       
        document.getElementById('popup').addEventListener('click', function(event) {
            if (event.target.id === 'popup') {
                document.getElementById('popup').classList.remove('show');
            }
        });

    
    </script>


<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    $('#regTable').DataTable();
});
</script>
</body>
</html>
