<?php

    // 127.0.0.1:8000/register.php?username=test_name4&email=test@test.com&password=Securepassword1

    include "auth.php";

    header("Content-Type: application/json");

    if (!empty($_REQUEST["username"]) || !empty($_REQUEST["email"])
       || !empty($_REQUEST["password"]))
    {
        $sanitized_name = trim(htmlspecialchars($_REQUEST["username"]));
        $sanitized_email = trim(htmlspecialchars($_REQUEST["email"]));
        $hashed_password = password_hash($_REQUEST["password"], PASSWORD_BCRYPT, ["cost" => 10]);
    
        $sql = "SELECT username FROM users WHERE username = '" . $sanitized_name . "';";
        $user_duplicate = $conn->query($sql)->fetch_assoc();

        if ($user_duplicate !== NULL)
        {
            echo "{\"error\": \"Username taken\"}";
            die();
        }

        $sql = "SELECT COUNT(username) FROM users;";
        $id = array_values($conn->query($sql)->fetch_assoc())[0];

        $sql = "INSERT INTO users VALUES ('" . $id . "', '" . $sanitized_name . "', '" . $sanitized_email . "', '0', '" . date('Y-m-d H:i:s') . "', '" . $hashed_password . "');";
        $conn->query($sql);

        echo "{\"success\": true}";
    }
    else
    {
        echo "{\"error\": \"Invalid form\"}";
    }


?>