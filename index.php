<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Registration</title>
</head>
<body>
<nav>
    <a href="registration.php">Stwórz konto</a>
    <?php
    if (isset($_SESSION["user"])) { ?>
        <a href="logout.php">Wyloguj się </a>
    <?php } else { ?><a href="login.php">Zaloguj się</a> <?php } ?>
</nav>
<h1>Witaj <?= $_SESSION["user"]["username"] ?></h1>
</body>
</html>