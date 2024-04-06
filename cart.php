<?php
    // http://127.0.0.1:8000/cart.php?note=Üzenet&price=1000&product=Valami&quantity=10
    
    include "auth.php";

    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, X-Requested-with, Authorization");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["username"]))
    {

        $sql = "SELECT COUNT(id) FROM cart;";
        $id = array_values($conn->query($sql)->fetch_assoc())[0];

        $sanitized_note = trim(htmlspecialchars($_REQUEST["note"]));
        $sanitized_price = (int)trim(htmlspecialchars($_REQUEST["price"]));
        $sanitized_product = trim(htmlspecialchars($_REQUEST["product"]));
        $sanitized_quantity = (int)trim(htmlspecialchars($_REQUEST["quantity"]));

        $sql = "INSERT INTO cart VALUES ('" . $id . "', '" . $_SESSION["id"] . "', '" . $sanitized_note . "', '" . $sanitized_price . "', '" . $sanitized_product . "', '" . $sanitized_quantity . "');";
        $conn->query($sql);

        echo "{\"success\": true}";
    }
    else if ($_SERVER["REQUEST_METHOD"] == "DELETE" && isset($_SESSION["username"]))
    {
        $sql = "DELETE FROM cart WHERE id = " . $_REQUEST["id"] . ";";
        $conn->query($sql);

        echo "{\"success\": true}";
    }
    else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_SESSION["admin"]))
    {
        $sql = "SELECT * FROM cart;";
        $results = array();
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) 
            array_push($results, $row);

        echo json_encode($results, true);
    }
?>