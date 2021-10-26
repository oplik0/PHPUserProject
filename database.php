<?php

$config = parse_ini_file("config.ini");
try {
    $db = new mysqli($config["db_url"], $config["db_username"], $config["db_password"], $config["db_name"]);
} catch (Exception $e) {
    http_response_code(500);
    return;
}
