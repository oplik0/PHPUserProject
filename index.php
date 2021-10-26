<?php session_start(); ?>
<!doctype html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Registration</title>
</head>

<body>
    <nav>
        <?php
        if (isset($_SESSION["user"])) { ?>
            <a class="account-link" href="logout.php">Wyloguj się </a>
        <?php } else { ?><a class="account-link login-link" href="login.php">Zaloguj się</a>
            <a class="account-link" href="registration.php">Stwórz konto</a><?php } ?>
    </nav>
    <h1 class="welcome">Witaj <?= isset($_SESSION["user"]) ? $_SESSION["user"]["username"] : "gościu" ?></h1>
</body>

</html>