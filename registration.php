<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta label="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    echo print_r($_POST);
    return;
}
$form = array(
    "username" => array(
        "label" => "nazwa użytkownika",
        "placeholder" => "nazwa użytkownika",
        "required" => true,
        "regex" => "{^\P{C}+$}iu",
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
        "regex" => "{^\P{C}+$}iu",
        "type" => "password"
    ),
    "name" => array(
        "label" => "imię",
        "placeholder" => "imię",
        "required" => true,
        "regex" => "{.*}iu",
        "type" => "text"
    ),
    "surname" => array(
        "label" => "nazwisko",
        "placeholder" => "nazwisko",
        "required" => true,
        "regex" => "{.*}iu",
        "type" => "text"
    ),
    "birthdate" => array(
        "label" => "data urodzenia",
        "placeholder" => "rrrr-mm-dd",
        "required" => true,
        "regex" => "{^\d{4}-\d{2}-\d{2}$}iu",
        "type" => "date"
    ),
    "PESEL" => array(
        "label" => "numer PESEL",
        "placeholder" => "XXXXXXXXXXX",
        "required" => true,
        "regex" => "{^\d{11}$}iu",
        "type" => "text"
    ),
    "NIP" => array(
        "label" => "NIP",
        "placeholder" => "XXX-XXX-XX-XX",
        "required" => false,
        "regex" => "{^(\d{3}-){2}\d{2}-\d{2}$}iu",
        "type" => "text"
    ),
    "postal_code" => array(
        "label" => "kod pocztowy",
        "placeholder" => "XX-XXX",
        "required" => true,
        "regex" => "{^\d{2}-\d{3}$}iu",
        "type" => "text"
    ),
    "city" => array(
        "label" => "miasto",
        "placeholder" => "miasto",
        "required" => true,
        "regex" => "{.*}iu",
        "type" => "text"
    ),
    "address" => array(
        "label" => "adres",
        "placeholder" => "adres",
        "required" => true,
        "regex" => "{.*}iu",
        "type" => "text"
    ),
    "phone" => array(
        "label" => "Telefon komórkowy",
        "placeholder" => "+XX XXX XXX XXX",
        "required" => false,
        "regex" => "{\+\d{2} (\d{3} ){2}\d{3}}iu",
        "type" => "tel"
    ),
    "landline" => array(
        "label" => "Telefon stacjonarny",
        "placeholder" => "XX XXX XX XXX",
        "required" => false,
        "regex" => "{^\d{2} \d{3} \d{2} \d{3}$}iu",
        "type" => "tel"
    )
);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once "database.php";
    if (isset($bolt)) {
        $bolt->begin();
        foreach ($_POST as $name => $value) {
            if (!array_key_exists($name, $form)) {
                continue;
            }
            if ($form[$name]["required"] && empty($value)) {
                http_response_code(400);
                echo "<h1>field " . $name . " is required</h1>";
                break;
            }
        }
    } else {
        http_response_code(500);
        return;
    }

}
?>
<form method="post">
    <?php
    foreach ($form as $pole => $props) {
        ?>
        <label id="<?= $pole ?>-label" for="<?= $pole ?>"><?= $props["label"] ?></label>
        <input
                id="<?= $pole ?>-input"
                name="<?= $pole ?>"
                type="<?= $props["type"] ?>"
                placeholder="<?= $props["placeholder"] ?>"
                pattern="<?= preg_replace("{(^\{|\}iu$)}iu", "", $props["regex"]) ?>"
            <?= $props["required"] ? "required" : "" ?>
        >
        <?php
    }
    ?>
    <input type="submit" name="submit" value="Wyślij">
</form>
</body>
</html>