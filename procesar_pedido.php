<?php
include 'catchai.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productos = $_POST['productos'];
    $fecha_pedido = date('Y-m-d');
    $hora_pedido = date('H:i:s');
    $total = 0;

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

    // Insertar el nuevo pedido en la tabla Pedido
    $stmt = $conn->prepare("INSERT INTO Pedido (FechaPedido, HoraPedido, PrecioTotal) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $fecha_pedido, $hora_pedido, $total);

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
