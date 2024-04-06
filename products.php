<?php
    // http://127.0.0.1:8000/products.php?season=nyár&name=Búza&quality=kiváló&price=1000
    
    include "auth.php";

    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, X-Requested-with, Authorization");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["username"]))
    {

        $sql = "SELECT COUNT(id) FROM products;";
        $id = array_values($conn->query($sql)->fetch_assoc())[0];
        
        $sanitized_season = trim(htmlspecialchars($_REQUEST["season"]));
        $sanitized_name = trim(htmlspecialchars($_REQUEST["name"]));
        $sanitized_quality = trim(htmlspecialchars($_REQUEST["quality"]));
        $sanitized_price = (int)trim(htmlspecialchars($_REQUEST["price"]));

        $sql = "INSERT INTO products VALUES ('" . $id . "', '" . $sanitized_season . "', '" . $sanitized_name . "', '" . $sanitized_quality . "', '" . $sanitized_price . "');";
        $conn->query($sql);

        echo "{\"success\": true}";
    }
    else if ($_SERVER["REQUEST_METHOD"] == "DELETE" && isset($_SESSION["username"]))
    {
        $sql = "DELETE FROM products WHERE id = " . $_REQUEST["id"] . ";";
        $conn->query($sql);

        echo "{\"success\": true}";
    }
    else if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $sql = "SELECT * FROM products;";
        $results = array();
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) 
            array_push($results, $row);

        echo json_encode($results, true);
    }
?>