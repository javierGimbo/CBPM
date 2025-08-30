<?php
$host = "localhost";
$user = "root";   // O el usuario que uses en phpMyAdmin
$pass = "";       // Tu contraseña (vacía por defecto en XAMPP)
$db = "CBPM";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
