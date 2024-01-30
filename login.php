<?php
    // http://127.0.0.1:8000/login.php?username=test_name4&password=Securepassword1

    include "auth.php";

    header("Content-Type: application/json");

    $sanitized_name = trim(htmlspecialchars($_REQUEST["username"]));

    $sql = "SELECT username FROM users WHERE username = '" . $sanitized_name . "'";
    $user_exists = $conn->query($sql)->fetch_assoc();

    if ($user_exists === NULL)
    {
        echo "{\"error\": \"Invalid username\"}";
        die();
    }

    $sql = "SELECT * FROM users WHERE username = '" . $sanitized_name . "'";
    $user_data = $conn->query($sql)->fetch_assoc();
    $hashed_password = $user_data["password"];

    if (password_verify($_REQUEST["password"], $hashed_password))
    {
        echo json_encode($user_data);
        
    }
    else
        echo "{\"error\": \"Invalid password\"}";
?>