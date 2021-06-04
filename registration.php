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
        $errors = array();
        $fields = array();
        $city = "";
        foreach ($_POST as $name => $value) {
            if (!array_key_exists($name, $form)) {
                continue;
            }
            if ($form[$name]["required"] && empty($value)) {
                http_response_code(400);
                array_push($errors, "<h1 class='error'>field " . $name . " is required</h1>");
                continue;
            } elseif (empty($value)) {
                continue;
            } elseif (!preg_match($form[$name]["regex"], $value)) {
                http_response_code(400);
                array_push($errors, "<h1 class='error'>field " . $name . "didn't match the required pattern</h1>");
                continue;
            }

            switch ($name) {
                case "password":
                    $value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
                    $fields["password"] = "'" . password_hash($value, PASSWORD_DEFAULT) . "'";
                    break;
                case "username":
                    $value = filter_var($value, FILTER_SANITIZE_STRING);
                    $bolt->run("OPTIONAL MATCH (u:User { username: '$value' }) RETURN u");
                    $user = $bolt->pull()[0][0];
                    if (!is_null($user)) {
                        http_response_code(409);
                        array_push($errors, "<h1 class='error'>user " . $value . " already exists</h1>");
                        break;
                    }
                    $fields["username"] = "'" . $value . "'";
                    break;
                case "birthdate":
                    $value = filter_var($value, FILTER_SANITIZE_STRING);
                    $fields["birthdate"] = "date('$value')";
                    break;
                case "email":
                    $fields["email"] = "'" . filter_var($value, FILTER_SANITIZE_EMAIL) . "'";
                    break;
                case "city":
                    $city = "'" . filter_var($value, FILTER_SANITIZE_STRING) . "'";
                    break;
                default:
                    $fields[$name] = "'" . filter_var($value, FILTER_SANITIZE_STRING) . "'";
                    break;
            }
        }
        if (count($errors) == 0) {

            try {
                session_destroy();
                $userQuery = $bolt->run("MERGE (c:City { name: $city })\n CREATE (u:User { " . implode(", ", array_map(function ($value, $key) {
                        return "$key: $value";
                    }, $fields, array_keys($fields))) . "})-[:LIVES_IN]->(c)\n RETURN u");
                $user = $bolt->pull()[0][0]->properties();
                $bolt->commit();
                session_start();
                $_SESSION["user"] = $user;
                header("Location: /");
                exit();
            } catch (Exception $e) {
                echo "<h1 class='error'>error insterting data: $e</h1>";
            }

        } else {
            echo print_r($errors);
        }
    } else {
        http_response_code(500);
        return;
    }

}
?>
<form class="user-form" method="post" action="/registration.php">
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
    <input class="submit-button" type="submit" name="submit" value="Wyślij">
</form>
</body>
</html>