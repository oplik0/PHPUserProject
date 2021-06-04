<?php

require_once "vendor/autoload.php";

use Bolt\Bolt;
use Bolt\connection\StreamSocket;

$config = parse_ini_file("config.ini");

try {
    $bolt = new Bolt(new StreamSocket());
} catch (Exception $e) {
    http_response_code(500);
    return;
}
$bolt->init($config["db_name"], $config["db_username"], $config["db_password"]);