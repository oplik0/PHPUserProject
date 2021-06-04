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
    if (isset($bolt)) {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $username = $_POST["username"];
            $bolt->run("OPTIONAL MATCH (u:User { username: '$username' } )\n RETURN u.password");
            $hash = $bolt->pull()[0];
            if (!is_null($hash) && count($hash) > 0 && password_verify($_POST["password"], $hash)) {
                session_start();
                if ($_POST["remember"]) {
                    session_set_cookie_params(2592000);
                }
                $bolt->run("MATCH (u:User { username: '$username' })\n RETURN u");
                $user = $bolt->pull()[0];
                $_SESSION["user"] = $user;
                header("Location: /");
            } else {
                echo "<h1 class='error'>Invalid username or password</h1>";
            }
        }
    }
}
?>
<form class="login" method="post" action="login.php">
    <label for="username">Nazwa użytkownika</label>
    <input name="username" type="text" placeholder="Nazwa użytkownika" pattern="^\P{C}{3,100}$">
    <label for="password">Hasło</label>
    <input name="password" type="password" pattern="^\P{C}{8,128}$">
    <label for="remember">Pamiętaj mnie</label>
    <input name="remember" type="checkbox">
    <input type="submit" value="Zaloguj się">
</form>
</body>
</html>