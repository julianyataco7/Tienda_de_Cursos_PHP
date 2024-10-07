<?php
$host = 'localhost';
$db = 'curso_inscripciones';
$user = 'root';
$pass = 'julian';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
