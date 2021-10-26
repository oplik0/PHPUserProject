<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once "../database.php";
    if (isset($db)) {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $username = $db->real_escape_string($_POST["username"]);
            $user_result = $db->query("SELECT `password` FROM `users` WHERE `username`='$username'");
            if (!$user_result) {
                echo "<h1 class='error'>Nieprawidłowa nazwa użytkownika lub hasło</h1>";
                exit(1);
            }
            $hash = $user_result->fetch_assoc()["password"];
            if (!is_null($hash) && password_verify($db->real_escape_string($_POST["password"]), $hash)) {
                session_start();
                if (isset($_POST["remember"]) && $_POST["remember"] == "on") {
                    session_set_cookie_params(2592000);
                }
                $user = $db->query("SELECT `username`, `name`, `lastname` FROM `users` WHERE `username`='$username'");
                $_SESSION["user"] = $user->fetch_assoc();
                header("Location: /");
            } else {
                echo "<h1 class='error'>Nieprawidłowa nazwa użytkownika lub hasło</h1>";
            }
        }
    }
}
