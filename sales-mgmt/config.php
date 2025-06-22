<?php
// config.php — тільки з’єднання з БД

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'sales-mgmt';  // якщо дійсно так називається ваша БД

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($mysqli->connect_error) {
    die('Connection error: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');

// Більше нічого тут не повинно бути — жодних prepare(), fetch() або HTML.
