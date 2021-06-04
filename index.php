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
$form = array(
    "imię" => array(
        "label" => "imię",
        "placeholder" => "imię",
        "required" => true,
        "regex" => "{.*}iu"
    ),
    "nazwisko" => array(
        "label" => "nazwisko",
        "placeholder" => "nazwisko",
        "required" => true,
        "regex" => "{.*}iu"
    ),
    "data_urodzenia" => array(
        "label" => "data urodzenia",
        "placeholder" => "rrrr-mm-dd",
        "required" => true,
        "regex" => "{^\d{4}-\d{2}-\d{2}$}iu"
    ),
    "pesel" => array(
        "label" => "numer PESEL",
        "placeholder" => "XXXXXXXXXXX",
        "required" => true,
        "regex" => "{^\d{11}$}iu"
    ),
    "NIP" => array(
        "label" => "NIP",
        "placeholder" => "XXX-XXX-XX-XX",
        "required" => false,
        "regex" => "{^(\d{3}-){2}\d{2}-\d{2}$}iu"
    ),
    "kod_pocztowy" => array(
        "label" => "kod pocztowy",
        "placeholder" => "XX-XXX",
        "required" => true,
        "regex" => "{^\d{2}-\d{3}$}iu"
    ),
    "miasto" => array(
        "label" => "miasto",
        "placeholder" => "miasto",
        "required" => true,
        "regex" => "{.*}iu"
    ),
    "adres" => array(
        "label" => "adres",
        "placeholder" => "adres",
        "required" => true,
        "regex" => "{.*}iu"
    ),
    "email" => array(
        "label" => "email",
        "placeholder" => "email@domena.com",
        "required" => true,
        "regex" => "{^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$}iu"
    ),
    "telefon" => array(
        "label" => "Telefon komórkowy",
        "placeholder" => "+XX XXX XXX XXX",
        "required" => false,
        "regex" => "{\+\d{2} (\d{3} ){3}}iu"
    ),
    "telefon stacjonarny" => array(
        "label" => "Telefon komórkowy",
        "placeholder" => "XX XXX XX XXX",
        "required" => false,
        "regex" => "{^\d{2} \d{3} \d{2} \d{3}$}iu"
    )
);


foreach ($form

as $pole => $props) {
?>
<input type="text" pattern="">
}
?>
</body>
</html>