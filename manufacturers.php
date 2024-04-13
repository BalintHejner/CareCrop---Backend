<?php
    // http://127.0.0.1:8000/manufacturers.php?name=Nagy+Lajos&address=Valami+utca+7&phone=06000000&banking=17291749174818
    
    include "auth.php";

    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, X-Requested-with, Authorization");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["username"]))
    {

        $sql = "SELECT COUNT(id) FROM manufacturers;";
        $id = array_values($conn->query($sql)->fetch_assoc())[0];

        $sanitized_name = trim(htmlspecialchars($_REQUEST["name"]));
        $sanitized_address = trim(htmlspecialchars($_REQUEST["address"]));
        $sanitized_phone = trim(htmlspecialchars($_REQUEST["phone"]));
        $sanitized_banking = trim(htmlspecialchars($_REQUEST["banking"]));

        $sql = "INSERT INTO manufacturers VALUES ('" . $id . "', '" . $sanitized_name . "', '" . $sanitized_address . "', '" . $sanitized_phone . "', '" . $sanitized_banking . "');";
        try {
            $conn->query($sql);
        } catch (Exception $e) {
            echo "{\"success\": false}";
            http_response_code(400);
            die();
        }

        echo "{\"success\": true}";
    }
    else if ($_SERVER["REQUEST_METHOD"] == "DELETE" && isset($_SESSION["username"]))
    {
        $sql = "DELETE FROM manufacturers WHERE id = " . $_REQUEST["id"] . ";";
        try {
            $conn->query($sql);
        } catch (Exception $e) {
            echo "{\"success\": false}";
            http_response_code(400);
            die();
        }

        echo "{\"success\": true}";
    }
    else if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $sql = "SELECT * FROM manufacturers;";
        $results = array();
        try {
            $result =$conn->query($sql);
        } catch (Exception $e) {
            echo "{\"success\": false}";
            http_response_code(400);
            die();
        }
        while($row = $result->fetch_assoc()) 
            array_push($results, $row);

        echo json_encode($results, true);
    }
?>