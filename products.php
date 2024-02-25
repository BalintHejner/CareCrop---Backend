<?php
    // http://127.0.0.1:8000/products.php?season=nyár&name=Búza&quality=kiváló&price=1000
    
    include "auth.php";

    session_start();
    header("Content-Type: application/json");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION["admin"])
    {

        $sql = "SELECT COUNT(id) FROM products;";
        $id = array_values($conn->query($sql)->fetch_assoc())[0];
        
        $sanitized_season = trim(htmlspecialchars($_POST["season"]));
        $sanitized_name = trim(htmlspecialchars($_POST["name"]));
        $sanitized_quality = trim(htmlspecialchars($_POST["quality"]));
        $sanitized_price = (int)trim(htmlspecialchars($_POST["price"]));

        $sql = "INSERT INTO products VALUES ('" . $id . "', '" . $sanitized_season . "', '" . $sanitized_name . "', '" . $sanitized_quality . "', '" . $sanitized_price . "');";
        $conn->query($sql);
    }
    else if ($_SERVER["REQUEST_METHOD"] == "DELETE" && $_SESSION["admin"])
    {
        $sql = "DELETE FROM products WHERE id = " . $_REQUEST["id"] . ";";
        $conn->query($sql);
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