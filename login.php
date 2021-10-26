<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once "database.php";
    if (isset($db)) {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $username = $db->real_escape_string($_POST["username"]);
            $user_result = $db->query("SELECT COUNT(*) AS `user_count`, `password` FROM `users` WHERE `username`='$username'");
            $hash = $user_result->fetch_assoc()["password"]
            if (!is_null($hash) && password_verify($db->real_escape_string($_POST["password"]), $hash)) {
                session_start();
                if (isset($_POST["remember"]) && $_POST["remember"] == "on") {
                    session_set_cookie_params(2592000);
                }
                $user = $db->query("SELECT `username`, `email` FROM `users` WHERE `username`='$username'")
                $_SESSION["user"] = $usert->fetch_assoc();
                header("Location: /");
            } else {
                echo "<h1 class='error'>Nieprawidłowa nazwa użytkownika lub hasło</h1>";
            }
        }
    }
}
?>
<form class="user-form" method="post" action="login.php">
    <label for="username">Nazwa użytkownika</label>
    <input name="username" type="text" placeholder="Nazwa użytkownika" pattern="^\P{C}{3,100}$">
    <label for="password">Hasło</label>
    <input name="password" type="password" pattern="^\P{C}{8,128}$">
    <label for="remember">Pamiętaj mnie</label>
    <input name="remember" type="checkbox">
    <input class="submit-button" type="submit" value="Zaloguj się">
</form>
</body>
</html>