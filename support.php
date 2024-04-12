<?php
    // 127.0.0.1:8000/support.php?message=Test!&type=3

    include "auth.php";

    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, X-Requested-with, Authorization");

    if (!isset($_SESSION["username"]))
    {
        echo "{\"error\": \"Nincs bejelentkezve!\"}";
        die();
    }    

    $sanitized_message = trim(htmlspecialchars($_REQUEST["message"]));
    $sanitized_type = (int)trim(htmlspecialchars($_REQUEST["type"]));

    $sql = "SELECT COUNT(id) FROM support;";
    $id = array_values($conn->query($sql)->fetch_assoc())[0];

    $sql = "INSERT INTO support VALUES ('" . $id . "', '" . $_SESSION["id"] . "', '" . $sanitized_message . "', '" . $sanitized_type . "');";
    try {
        $conn->query($sql);
    } catch (Exception $e) {
        echo "{\"success\": false}";
        die();
    }

    echo "{\"success\": true}";
?>