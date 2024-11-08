<?php
include 'catchai.php';

date_default_timezone_set("America/La_Paz"); // Configura la zona horaria

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $cliente_id = $_POST['cliente_id'];
    $descuento_id = $_POST['descuento_id'] ?? null;
    $precio_total = $_POST['precio_total'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $hora_entrega = $_POST['hora_entrega'];

    $hora_actual = date("H:i"); // Hora actual en formato de 24 horas

    // Verifica si la solicitud se realiza en el horario permitido
    if ($hora_actual < "08:00" || $hora_actual > "17:00") {
        echo "Los pedidos solo pueden ser procesados entre las 8:00 a.m. y las 5:00 p.m.";
        exit;
    }

    if ($accion == "agregar") {
        $fecha_pedido = date("Y-m-d");
        $hora_pedido = date("H:i");

        $sql = "INSERT INTO Pedido (FechaPedido, FechaEntrega, PrecioTotal, HoraPedido, HoraEntrega, Cliente_IdPersona, Descuentos_IdDescuentos)
                VALUES ('$fecha_pedido', '$fecha_entrega', '$precio_total', '$hora_pedido', '$hora_entrega', '$cliente_id', '$descuento_id')";

        if ($conn->query($sql) === TRUE) {
            echo "Pedido agregado correctamente.";
        } else {
            echo "Error al agregar el pedido: " . $conn->error;
        }
    } elseif ($accion == "cancelar") {
        $pedido_id = $_POST['pedido_id'];
        $sql = "DELETE FROM Pedido WHERE IdPedido = '$pedido_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Pedido cancelado correctamente.";
        } else {
            echo "Error al cancelar el pedido: " . $conn->error;
        }
    }
}

$conn->close();
header("Location: pedidos.php");
?>
