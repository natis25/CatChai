<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="pedidos.css">
    <title>Detalles del Pedido</title>
</head>
<body>
    <h1>Detalles del Pedido</h1>

    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio por Producto</th>
        </tr>
        <?php
        include 'catchai.php';

        // Obtén el IdPedido desde los parámetros GET
        $idPedido = intval($_GET['id']);

        // Consulta para obtener los detalles del pedido
        $query = "SELECT Producto.Producto AS Producto, PedidoProducto.Cantidad, PedidoProducto.PrecioPP
                  FROM PedidoProducto
                  JOIN Producto ON PedidoProducto.Producto_IdProducto = Producto.IdProducto
                  WHERE PedidoProducto.Pedido_IdPedido = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idPedido);

        // Ejecuta y verifica errores
        if (!$stmt->execute()) {
            die("Error al ejecutar la consulta: " . $stmt->error);
        }

        $result = $stmt->get_result();

        // Verifica si hay resultados
        if ($result->num_rows > 0) {
            // Muestra los productos del pedido
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['Producto']}</td>
                        <td>{$row['Cantidad']}</td>
                        <td>Bs{$row['PrecioPP']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No se encontraron productos para este pedido.</td></tr>";
        }

        $stmt->close();

        // Consulta para obtener el precio total del pedido
        $queryTotal = "SELECT PrecioTotal FROM Pedido WHERE IdPedido = ?";
        $stmtTotal = $conn->prepare($queryTotal);
        $stmtTotal->bind_param("i", $idPedido);

        if (!$stmtTotal->execute()) {
            die("Error al obtener el precio total: " . $stmtTotal->error);
        }

        $stmtTotal->bind_result($precioTotal);
        $stmtTotal->fetch();

        echo "<tr>
                <td colspan='2'><strong>Total</strong></td>
                <td><strong>Bs{$precioTotal}</strong></td>
              </tr>";

        $stmtTotal->close();
        $conn->close();
        ?>
    </table>

    <a href="listar_pedidos.php">Volver a la Lista de Pedidos</a>
</body>
</html>
