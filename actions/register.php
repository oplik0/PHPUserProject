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
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        require_once "database.php";
        if (isset($db)) {
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
                        $value = $db->real_escape_string($value);
                        $fields["password"] = password_hash($value, PASSWORD_DEFAULT);
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
                        $fields["email"] = $db->real_escape_string($value);
                        break;
                    default:
                        $fields[$name] = $db->real_escape_string($value);
                        break;
                }
            }
            if (count($errors) == 0) {

                try {
                    $db->begin_transaction();
                    session_destroy();
                    $columns = "`" . implode("`, `", array_keys($fields)) . "`";
                    $values = "'" . implode("', '", array_values($fields)) . "'";
                    $insertUserQuery = "INSERT INTO `users` ($columns) VALUES $values";
                    $db->query($insertUserQuery);
                    $db->commit();
                    $username = $fields["username"];
                    $getUserQuery = "SELECT `username`, `email` FROM users WHERE `username`='$username'";
                    $user = $db->query($getUserQuery);
                    $_SESSION["user"] = $user->fetch_assoc();
                    header("Location: /");
                    exit();
                } catch (Exception $e) {
                    $db->rollback();
                }
            } else {
                echo print_r($errors);
            }
        } else {
            http_response_code(500);
            return;
        }
    }
