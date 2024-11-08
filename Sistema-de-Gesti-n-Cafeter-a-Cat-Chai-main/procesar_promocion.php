<?php
include 'catchai.php';

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $id = $_POST['id'];
    $descuento = $_POST['descuento'];
    $porcentaje = $_POST['porcentaje'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    switch ($accion) {
        case 'crear':
            $sql = "INSERT INTO Descuentos (Descuento, Porcentaje, FechaInicio, FechaFin)
                    VALUES ('$descuento', '$porcentaje', '$fecha_inicio', '$fecha_fin')";
            break;

        case 'editar':
            $sql = "UPDATE Descuentos SET Descuento='$descuento', Porcentaje='$porcentaje',
                    FechaInicio='$fecha_inicio', FechaFin='$fecha_fin' WHERE IdDescuentos='$id'";
            break;

        case 'eliminar':
            $sql = "DELETE FROM Descuentos WHERE IdDescuentos='$id'";
            break;
    }

    if ($conn->query($sql) === TRUE) {
        echo "Operación exitosa";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
header("Location: promociones.php");
