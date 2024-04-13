<?php
    session_start();
    header("Content-Type: application/json");

    if (isset($_SESSION["username"]))
    {
        $user_data = $_SESSION;
        unset($user_data["password"]);
        echo json_encode($user_data, true);
    }
?>