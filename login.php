<?php
    // http://127.0.0.1:8000/login.php?username=test_name4&password=Securepassword1
    
    include "auth.php";

    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, X-Requested-with, Authorization");

    if (isset($_SESSION["username"]))
    {
        echo "{\"error\": \"Ön már bejelentkezett!\"}";
        die();
    }    

    $sanitized_name = trim(htmlspecialchars($_REQUEST["username"]));

    $sql = "SELECT username FROM users WHERE username = '" . $sanitized_name . "'";
    $user_exists = $conn->query($sql)->fetch_assoc();

    if ($user_exists === NULL)
    {
        echo "{\"error\": \"Érvénytelen felhasználónév!\"}";
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
        echo "{\"error\": \"Érvénytelen jelszó!\"}";
?>