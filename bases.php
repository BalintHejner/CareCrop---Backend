<?php
    // http://127.0.0.1:8000/bases.php?address=Valami+utca+7

    include "auth.php";

    session_start();
    header("Content-Type: application/json");

    if (isset($_SESSION["admin"]))
    {

        $sql = "SELECT COUNT(id) FROM bases;";
        $id = array_values($conn->query($sql)->fetch_assoc())[0];

        $sanitized_address = trim(htmlspecialchars($_REQUEST["address"]));

        $sql = "INSERT INTO products VALUES ('" . $id . "', '" . $sanitized_address . "');";
        cconn->query($sql);
    }
?>