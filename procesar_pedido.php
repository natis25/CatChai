<?php
include 'catchai.php';
session_start(); // Asegúrate de que la sesión esté iniciada

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtén el ID del usuario desde la sesión
    if (!isset($_SESSION['IdPersona'])) {
        echo "Error: Usuario no autenticado.";
        exit;
    }
    $idPersona = $_SESSION['IdPersona'];

    $productos = json_decode($_POST['productos'], true);
    if (!$productos) {
        echo "No se recibieron productos.";
        exit;
    }

    $fecha_pedido = date('Y-m-d');
    $hora_pedido = date('H:i:s');
    $total = 0;

    // Verificar si hay un descuento activo
    $hoy = date('Y-m-d');
    $queryDescuento = "SELECT Porcentaje FROM descuentos WHERE FechaInicio <= '$hoy' AND FechaFin >= '$hoy' LIMIT 1";
    $resultDescuento = $conn->query($queryDescuento);
    $porcentajeDescuento = 0;

    if ($resultDescuento && $rowDescuento = $resultDescuento->fetch_assoc()) {
        $porcentajeDescuento = $rowDescuento['Porcentaje']; // Obtén el porcentaje del descuento
    }

    // Calcular el total y verificar la disponibilidad de cada producto
    foreach ($productos as $idProducto => $cantidad) {
        if ($cantidad > 0) {
            $query = "SELECT Precio, Disponibilidad FROM Producto WHERE idProducto = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $idProducto);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $precio = $result['Precio'];
            $disponibilidad = $result['Disponibilidad'];

            if ($cantidad > $disponibilidad) {
                echo "Error: La cantidad solicitada del producto con ID $idProducto excede la disponibilidad.";
                exit;
            }

            $total += $precio * $cantidad;
            $stmt->close();
        }
    }

    // Aplicar el descuento al total si corresponde
    if ($porcentajeDescuento > 0) {
        $descuentoAplicado = $total * ($porcentajeDescuento / 100);
        $total -= $descuentoAplicado; // Total con el descuento aplicado
    }

    // Insertar el nuevo pedido en la tabla Pedido, incluyendo Cliente_IdPersona y PrecioTotal con descuento
    $stmt = $conn->prepare("INSERT INTO Pedido (FechaPedido, HoraPedido, PrecioTotal, Cliente_IdPersona) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $fecha_pedido, $hora_pedido, $total, $idPersona);

    if ($stmt->execute()) {
        $idPedido = $stmt->insert_id; // Obtener el ID del nuevo pedido insertado

        // Insertar cada producto en PedidoProducto y actualizar la disponibilidad
        foreach ($productos as $idProducto => $cantidad) {
            if ($cantidad > 0) {
                // Obtener el precio unitario del producto
                $queryPrecio = "SELECT Precio FROM Producto WHERE idProducto = ?";
                $stmtPrecio = $conn->prepare($queryPrecio);
                $stmtPrecio->bind_param("i", $idProducto);
                $stmtPrecio->execute();
                $resultPrecio = $stmtPrecio->get_result()->fetch_assoc();
                $precioUnitario = $resultPrecio['Precio'];
                $stmtPrecio->close();

                // Calcular el precio total para la cantidad de ese producto
                $precioPP = $precioUnitario * $cantidad;

                // Insertar en PedidoProducto
                $stmtPP = $conn->prepare("INSERT INTO PedidoProducto (Cantidad, PrecioPP, Pedido_IdPedido, Producto_idProducto) VALUES (?, ?, ?, ?)");
                $stmtPP->bind_param("idii", $cantidad, $precioPP, $idPedido, $idProducto);
                $stmtPP->execute();
                $stmtPP->close();

                // Actualizar disponibilidad del producto
                $nuevaDisponibilidad = $disponibilidad - $cantidad;
                $stmtUpdate = $conn->prepare("UPDATE Producto SET Disponibilidad = ? WHERE idProducto = ?");
                $stmtUpdate->bind_param("ii", $nuevaDisponibilidad, $idProducto);
                $stmtUpdate->execute();
                $stmtUpdate->close();
            }
        }

        // Redirigir a pedidos.php con mensaje de éxito
        header("Location: pedidos.php?mensaje=pedido_agregado");
        exit;
    } else {
        echo "Error al procesar el pedido: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
}
?>
