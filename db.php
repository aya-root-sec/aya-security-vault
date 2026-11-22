<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'emergency_db';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "فشل الاتصال بقاعدة البيانات"]));
}
$conn->set_charset("utf8");
?>