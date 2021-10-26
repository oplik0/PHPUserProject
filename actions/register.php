<?php
session_start();
$form = array(
    "username" => array(
        "label" => "nazwa użytkownika",
        "placeholder" => "nazwa użytkownika",
        "required" => true,
        "regex" => "{^\P{C}{3,100}$}iu",
        "type" => "text"
    ),
    "name" => array(
        "label" => "imię",
        "placeholder" => "Jan",
        "required" => true,
        "regex" => "{^\P{C}{3,100}$}iu",
        "type" => "text"
    ),
    "lastname" => array(
        "label" => "nazwisko",
        "placeholder" => "Kowalski",
        "required" => true,
        "regex" => "{^\P{C}{3,100}$}iu",
        "type" => "text"
    ),
    "age" => array(
        "label" => "wiek",
        "placeholder" => "18",
        "required" => true,
        "regex" => "{^(1[4-9]|[2-9][0-9]|1[0-2][0-9])$}i",
        "type" => "text"
    ),
    "password" => array(
        "label" => "hasło",
        "placeholder" => "********",
        "required" => true,
        "regex" => "{^\P{C}{8,128}$}iu",
        "type" => "password"
    )
);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once "../database.php";
    if (isset($db)) {
        $errors = array();
        $fields = array();
        $city = "";
        $fields["role"] = "'user'";
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
                    $value = $db->real_escape_string($value);
                    $fields["password"] = "'" . password_hash($value, PASSWORD_DEFAULT) . "'";
                    break;
                case "username":
                    $value = $db->real_escape_string($value);
                    $result = $db->query("SELECT COUNT(*) AS `user_count` FROM `users` WHERE `username` = '$value'");
                    $user = $result->fetch_assoc();
                    if ($user["user_count"] > 0) {
                        http_response_code(409);
                        array_push($errors, "<h1 class='error'>user " . $value . " already exists</h1>");
                        break;
                    }
                    $fields["username"] = "'" . $value . "'";
                    break;
                case "email":
                    $fields["email"] = "'" . $db->real_escape_string($value) . "'";
                    break;
                case "age":
                    $value = intval($value, 10);
                    if ($value < 13 || $value > 130) {
                        http_response_code(409);
                        array_push($errors, "<h1 class='error'>age " . $value . " is outside of permitted range</h1>");
                        break;
                    }
                    $fields["age"] = $value;
                    break;
                default:
                    $fields[$name] = "'" . $db->real_escape_string($value) . "'";
                    break;
            }
        }
        if (count($errors) == 0) {

            try {
                header("test: test");
                $db->begin_transaction();
                $columns = "`" . implode("`, `", array_keys($fields)) . "`";
                $values = implode(", ", array_values($fields));
                $insertUserQuery = "INSERT INTO `users` ($columns) VALUES ($values)";
                $db->query($insertUserQuery);
                $db->commit();
                $username = $fields["username"];
                $getUserQuery = "SELECT `username`, `name`, `lastname` FROM users WHERE `username`=$username";
                $user = $db->query($getUserQuery);
                if (!$user) {
                    echo $user . $getUserQuery;
                    http_response_code(500);
                    array_push($errors, "didn't find user");
                    throw new Exception("failed inserting user");
                }
                $_SESSION["user"] = $user->fetch_assoc();
                header("Location: /");
                exit();
            } catch (Exception $e) {
                $db->rollback();
            }
        }
        echo print_r($errors);
    } else {
        http_response_code(500);
        return;
    }
}
