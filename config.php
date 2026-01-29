<?php
$host = 'db'; 
$user = getenv('MYSQL_USER');     // هيسحب ehab من الـ .env
$pass = getenv('MYSQL_PASSWORD'); // هيسحب 123456 من الـ .env
$db   = getenv('MYSQL_DATABASE'); // هيسحب mydb من الـ .env

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die('Connection Error: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
?>
