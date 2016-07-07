<?php

session_start();

require_once __DIR__."/User.php";
require_once __DIR__."/Tweet.php";
require_once __DIR__."/Comment.php";
require_once __DIR__."/Message.php";

$db_host = "localhost";
$db_user = "root";
$db_password = "coderslab";
$db_name = "Twitter";

$db_conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($db_conn->connect_error) {
    die("Polaczenie nieudane. Blad: " . $db_conn->connect_error);
}

