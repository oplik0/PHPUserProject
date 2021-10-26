<!doctype html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>

<body>
    <form class="user-form" method="post" action="/actions/login.php">
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