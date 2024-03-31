<?php
    // http://127.0.0.1:8000/manufacturers.php?name=Nagy+Lajos&address=Valami+utca+7&phone=06000000&banking=17291749174818
    
    include "auth.php";

    session_start();
    header("Content-Type: application/json");

    if (isset($_SESSION["admin"]))
    {

        $sql = "SELECT COUNT(id) FROM manufacturers;";
        $id = array_values($conn->query($sql)->fetch_assoc())[0];

        $sanitized_name = trim(htmlspecialchars($_REQUEST["name"]));
        $sanitized_address = trim(htmlspecialchars($_REQUEST["address"]));
        $sanitized_phone = trim(htmlspecialchars($_REQUEST["phone"]));
        $sanitized_banking = trim(htmlspecialchars($_REQUEST["banking"]));

        $sql = "INSERT INTO products VALUES ('" . $id . "', '" . $sanitized_name . "', '" . $sanitized_address . "', '" . $sanitized_phone . "', '" . $sanitized_banking . "');";
        cconn->query($sql);
    }
?>