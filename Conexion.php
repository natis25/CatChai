<?php
    $host = "localhost";
    $User = "root";
    $pass = "";
    $db = "cat_chai";

    $conexion = mysqli_connect($host, $User, $pass, $db);

    if (!$conexion) {
        echo "Conexión fallida";
    }
?>
