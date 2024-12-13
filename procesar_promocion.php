<?php
include 'catchai.php';
session_start();

// Verifica que se haya enviado una acción
if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $id = isset($_POST['id_descuento']) ? intval($_POST['id_descuento']) : null; // Sanitización del ID
    $descuento = isset($_POST['descuento']) ? $conn->real_escape_string(trim($_POST['descuento'])) : null;
    $porcentaje = isset($_POST['porcentaje']) ? floatval($_POST['porcentaje']) : null;
    $fecha_inicio = isset($_POST['fecha_inicio']) ? $conn->real_escape_string(trim($_POST['fecha_inicio'])) : null;
    $fecha_fin = isset($_POST['fecha_fin']) ? $conn->real_escape_string(trim($_POST['fecha_fin'])) : null;

    // Validaciones básicas
    if ($accion === 'crear' || $accion === 'editar') {
        if (empty($descuento) || $porcentaje < 0 || $porcentaje > 100 || strtotime($fecha_inicio) > strtotime($fecha_fin)) {
            $_SESSION['mensaje'] = "Datos inválidos. Verifica el formulario.";
            header("Location: promociones.php");
            exit;
        }
    }

    // Construcción de la consulta según la acción
    switch ($accion) {
        case 'crear':
            $sql = "INSERT INTO Descuentos (Descuento, Porcentaje, FechaInicio, FechaFin)
                    VALUES ('$descuento', $porcentaje, '$fecha_inicio', '$fecha_fin')";
            break;

        case 'editar':
            if ($id) {
                $sql = "UPDATE Descuentos 
                        SET Descuento = '$descuento', Porcentaje = $porcentaje, 
                            FechaInicio = '$fecha_inicio', FechaFin = '$fecha_fin' 
                        WHERE IdDescuentos = $id";
            } else {
                $_SESSION['mensaje'] = "ID de promoción inválido.";
                header("Location: promociones.php");
                exit;
            }
            break;

        case 'eliminar':
            if ($id) {
                $sql = "DELETE FROM Descuentos WHERE IdDescuentos = $id";
            } else {
                $_SESSION['mensaje'] = "ID de promoción inválido.";
                header("Location: promociones.php");
                exit;
            }
            break;

        default:
            $_SESSION['mensaje'] = "Acción no válida.";
            header("Location: promociones.php");
            exit;
    }

    // Ejecución de la consulta
    if (isset($sql) && $conn->query($sql) === TRUE) {
        $_SESSION['mensaje'] = "Operación realizada con éxito.";
    } else {
        $_SESSION['mensaje'] = "Error: " . $conn->error;
    }
} else {
    $_SESSION['mensaje'] = "No se recibió ninguna acción.";
}

// Cierra la conexión y redirige
$conn->close();
header("Location: promociones.php");
exit;
?>
