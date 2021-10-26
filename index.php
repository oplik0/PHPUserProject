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
            <?php } else { ?><?php } ?>
    </nav>
    <main>
        <?php if (isset($_SESSION["user"])) { ?>
            <h1 class="welcome">Witaj <?= $_SESSION["user"]["username"] ?></h1>
        <?php
        } else { ?>
            <a class="account-link login-link" href="/pages/login.php">Zaloguj się</a>
            <a class="account-link register-link" href="/pages/register.php">Zarejestruj się</a>
        <?php
        }
        ?>
    </main>
</body>

</html>