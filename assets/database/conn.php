<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header('Content-Type: application/json');

    $dsn = "mysql:host=localhost;dbname=cybervlog";
    $dbusername = 'root';
    $dbpassword = '';

    try{
        $pdo = new PDO($dsn, $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo ('<script> console.log("Successful Connection.") </script>');

    } catch (PDOException $e) {
        echo  "Connection Failed: " .$e->getMessage();
    }
?>