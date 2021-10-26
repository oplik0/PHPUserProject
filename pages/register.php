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
    <?php
    $form = array(
        "username" => array(
            "label" => "nazwa użytkownika",
            "placeholder" => "nazwa użytkownika",
            "required" => true,
            "regex" => "{^\P{C}{3,100}$}iu",
            "type" => "text"
        ),
        "email" => array(
            "label" => "email",
            "placeholder" => "email@domena.com",
            "required" => true,
            "regex" => "{^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$}iu",
            "type" => "email"
        ),
        "password" => array(
            "label" => "hasło",
            "placeholder" => "********",
            "required" => true,
            "regex" => "{^\P{C}{8,128}$}iu",
            "type" => "password"
        )
    );
    ?>
    <form class="user-form" method="post" action="/registration.php">
        <?php
        foreach ($form as $pole => $props) {
        ?>
            <label id="<?= $pole ?>-label" for="<?= $pole ?>"><?= $props["label"] ?></label>
            <input id="<?= $pole ?>-input" name="<?= $pole ?>" type="<?= $props["type"] ?>" placeholder="<?= $props["placeholder"] ?>" pattern="<?= preg_replace("{(^\{|\}iu$)}iu", "", $props["regex"]) ?>" <?= $props["required"] ? "required" : "" ?>>
        <?php
        }
        ?>
        <input class="submit-button" type="submit" name="submit" value="Wyślij">
    </form>
</body>

</html>

</html>