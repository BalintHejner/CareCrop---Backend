<?php
    // http://127.0.0.1:8000/login.php?username=test_name4&password=Securepassword1
    
    include "auth.php";

    session_start();
    header("Content-Type: application/json");

    if (isset($_SESSION["username"]))
    {
        echo "{\"error\": \"You are already logged in\"}";
        die();
    }    

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
        foreach ($user_data as $key => $value)
        {
            $_SESSION[$key] = $value;
        }

        echo "{\"success\": true}";
    }
    else
        echo "{\"error\": \"Invalid password\"}";
?>