<?php
    session_start();

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header('Content-Type: application/json');
    
    include_once('conn.php');
    
    $method = $_SERVER['REQUEST_METHOD'];
    
    switch ($method) {
        case 'GET':
            handleGet_reg_count($pdo);
            break;
        // case 'PUT':
        //     handlePut($pdo);
        //     break;
        default:
            echo json_encode(["message" => "Method not supported"]);
            break;
    }
    
    // this method will get the information of regular visitors
    function handleGet_reg_count($pdo) {
        try {
            $sql = "SELECT * FROM tb_regular";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode($data);
        } catch (PDOException $e) {
            echo json_encode(["message" => "Error: " . $e->getMessage()]);
        }
    }    
?>