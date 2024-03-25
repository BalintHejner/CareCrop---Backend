<?php
    // http://127.0.0.1:8000/cart.php
    
    include "auth.php";

    session_start();
    header("Content-Type: application/json");

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $sql = "INSERT INTO purchases VALUES (";

        foreach($_POST as $key => $value)
        {
            $sql .= "'" . trim(htmlspecialchars($value)) . "',";
        }

        $sql = rtrim($sql, ", ");
        $sql .= ");";
    
        $conn->query($sql);

        echo "{\"success\": true}";
    }
?>