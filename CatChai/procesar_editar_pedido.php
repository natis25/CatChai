<?php
include 'catchai.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPedido = $_POST['idPedido'];
    $productos = $_POST['productos'];

    foreach ($productos as $idProducto => $nuevaCantidad) {
        // Obtener la cantidad actual
        $query = "SELECT Cantidad FROM PedidoProducto WHERE Pedido_IdPedido = ? AND Producto_idProducto = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $idPedido, $idProducto);
        $stmt->execute();
        $result = $stmt->get_result();
        $pedidoProducto = $result->fetch_assoc();
        $stmt->close();

        if ($pedidoProducto) {
            $cantidadActual = $pedidoProducto['Cantidad'];
            $diferenciaCantidad = $nuevaCantidad - $cantidadActual;

            // Actualizar la cantidad en PedidoProducto
            $queryUpdate = "UPDATE PedidoProducto SET Cantidad = ? WHERE Pedido_IdPedido = ? AND Producto_idProducto = ?";
            $stmtUpdate = $conn->prepare($queryUpdate);
            $stmtUpdate->bind_param("iii", $nuevaCantidad, $idPedido, $idProducto);
            $stmtUpdate->execute();
            $stmtUpdate->close();

            // Ajustar disponibilidad del producto
            $queryUpdateProducto = "UPDATE Producto SET Disponibilidad = Disponibilidad - ? WHERE idProducto = ?";
            $stmtProducto = $conn->prepare($queryUpdateProducto);
            $stmtProducto->bind_param("ii", $diferenciaCantidad, $idProducto);
            $stmtProducto->execute();
            $stmtProducto->close();
        }
    }

    // Redirigir a la lista de pedidos con un mensaje de éxito
    header("Location: listar_pedidos.php?mensaje=pedido_editado");
}
?>
