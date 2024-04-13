<?php
    include "auth.php";

    session_start();
    header("Content-Type: application/json");

    if (isset($_SESSION["username"]))
    {
       if (password_verify($_REQUEST["password"], $_SESSION["password"]))
       {
            $hashed_new_password = password_hash($_REQUEST["new_password"], PASSWORD_BCRYPT, ["cost" => 10]);

            $sql = "UPDATE users SET password = '" . $hashed_new_password . "' WHERE id = '" . $_SESSION["id"] . "';";
            try {
                $conn->query($sql);
            } catch (Exception $e) {
                echo "{\"success\": false}";
                http_response_code(400);
                die();
            }

            echo "{\"success\": true}";
            session_destroy();
       }
       else
       {
            echo "{\"error\": \"A régi jelszó nem helyes!\"}";
            http_response_code(400);
       }
    }
?>