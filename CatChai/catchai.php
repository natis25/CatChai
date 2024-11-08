<?php
// catchai.php
$servername = "localhost"; // Cambia esto si usas otro servidor
$username = "root";        // Nombre de usuario de MySQL
$password = "";            // Contraseña de MySQL
$dbname = "catchai"; // Cambia a tu nombre de base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
