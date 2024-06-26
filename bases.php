<?php
    // http://127.0.0.1:8000/bases.php?address=Valami+utca+7

    include "auth.php";

    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, X-Requested-with, Authorization");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["username"]))
    {

        $sql = "SELECT COUNT(id) FROM bases;";
        $id = array_values($conn->query($sql)->fetch_assoc())[0];

        $sanitized_address = trim(htmlspecialchars($_REQUEST["address"]));

        $sql = "INSERT INTO bases VALUES ('" . $id . "', '" . $sanitized_address . "');";
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
        $sql = "DELETE FROM bases WHERE id = " . $_REQUEST["id"] . ";";
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
        $sql = "SELECT * FROM bases;";
        $results = array();
        try {
            $result = $conn->query($sql);
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