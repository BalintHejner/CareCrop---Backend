<?php

    // 127.0.0.1:8000/register.php?username=test_name4&email=test@test.com&password=Securepassword1

    include "auth.php";

    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, X-Requested-with, Authorization");

    if (isset($_SESSION["username"]))
    {
        echo "{\"error\": \"Ön már be van jelentkezve\"}";
        die();
    }    

    if (!empty($_REQUEST["username"]) || !empty($_REQUEST["email"])
       || !empty($_REQUEST["password"]))
    {
        $sanitized_name = trim(htmlspecialchars($_REQUEST["username"]));
        $sanitized_email = trim(htmlspecialchars($_REQUEST["email"]));
        $hashed_password = password_hash($_REQUEST["password"], PASSWORD_BCRYPT, ["cost" => 10]);
    
        $sqlUsername = "SELECT username FROM users WHERE username = '" . $sanitized_name . "';";
        $sqlEmail = "SELECT username FROM users WHERE email = '" . $sanitized_email . "';";
        $user_duplicate = $conn->query($sqlUsername)->fetch_assoc();
        $email_duplicate = $conn->query($sqlEmail)->fetch_assoc();

        if ($user_duplicate !== NULL)
        {
            echo "{\"error\": \"A felhasználónév már létezik!\"}";
            http_response_code(400);
            die();
        }
        if ($email_duplicate !== NULL)
        {
            echo "{\"error\": \"Ezzel az email címmel már létezik fiók!\"}";
            http_response_code(400);
            die();
        }

        if (1 > strlen($sanitized_name) || strlen($sanitized_name) > 256)
        {
            echo "{\"error\": \"Nem megfelelő hosszúságú név!\"}";
            http_response_code(400);
            die();
        }

        if (1 > strlen($sanitized_email) || strlen($sanitized_email) > 256)
        {
            echo "{\"error\": \"Nem megfelelő hosszúságú email!\"}";
            http_response_code(400);
            die();
        }

        $sql = "SELECT COUNT(username) FROM users;";
        $id = array_values($conn->query($sql)->fetch_assoc())[0];

        $sql = "INSERT INTO users VALUES ('" . $id . "', '" . $sanitized_name . "', '" . $sanitized_email . "', '0', '" . date('Y-m-d H:i:s') . "', '" . $hashed_password . "');";
        
        try {
            $conn->query($sql);
        } catch (Exception $e) {
            echo "{\"success\": false}";
            http_response_code(400);
            die();
        }
        
        echo "{\"success\": true}";
    }
    else
    {
        echo "{\"error\": \"Érvénytelen adatok!\"}";
        http_response_code(400);
    }


?>