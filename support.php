<?php
    // 127.0.0.1:8000/support.php?message=Test!&type=3

    include "auth.php";

    session_start();
    header("Content-Type: application/json");

    if (!isset($_SESSION["username"]))
    {
        echo "{\"error\": \"You are not logged in\"}";
        die();
    }    

    $sanitized_message = trim(htmlspecialchars($_REQUEST["message"]));
    $sanitized_type = (int)trim(htmlspecialchars($_REQUEST["type"]));

    $sql = "SELECT COUNT(id) FROM support;";
    $id = array_values($conn->query($sql)->fetch_assoc())[0];

    $sql = "INSERT INTO support VALUES ('" . $id . "', '" . $_SESSION["id"] . "', '" . $sanitized_message . "', '" . $sanitized_type . "');";
    $conn->query($sql);

    echo "{\"success\": true}";
?>