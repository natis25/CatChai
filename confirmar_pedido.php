<?php
include 'catchai.php';

if (isset($_GET['id'])) {
    $idPedido = intval($_GET['id']);

    // Actualiza el estado del pedido a true
    $query = "UPDATE Pedido SET Estado = 1 WHERE IdPedido = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $idPedido);

    if ($stmt->execute()) {
        // Redirige a la lista de pedidos con un mensaje de éxito
        header("Location: listar_pedidos.php?mensaje=Pedido confirmado correctamente");
        exit();
    } else {
        // Redirige con un mensaje de error
        header("Location: listar_pedidos.php?mensaje=Error al confirmar el pedido");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
