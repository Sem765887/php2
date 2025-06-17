<?php
$host = "localhost";
$user = "fjttkvkf";
$password = "Ven5U5";
$db = "fjttkvkf_m4";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>