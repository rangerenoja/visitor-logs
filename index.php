<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: ../cyber/assets/dashboard.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>External CSS Background Image</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>




<form method="post" action="assets/database/login.php">
    <div class="logobox">
        <img src="assets/img/logo.png" alt="Logo" class="logo">
        <p class="welcome">WELCOME TO <BR> CYBER BATTALION</p>
        
    </div>

    <div class="loginbox">
        <p class="text">CYBER</p>
        <p class="text2">VISITOR'S LOG</p>
        <p class="text3">LOG-IN</p>
        
    </div>

    <div class="underline">
   <?php if(isset($_SESSION['error'])){
    echo ' <div class="alert alert-danger" role="alert">
  Incorrect Username or Password
</div>';
unset($_SESSION['error']);
   }
    ?>
    </div>
    <div class="box">
        
        <img src="assets/img/user-icon.png" alt="user" class="user">  
        <input type="text" name="username" class="username-input" placeholder="Enter your username">
    </div>
 
    <div class="box2">
        <img src="assets/img/padlock.png" alt="padlock" class="padlock">     
        <input type="password" name="password" class="password-input" placeholder="Enter your password">    
        <button type="submit" class="submit-button">Submit</button>
    </div>
</form>


</body>
</html>