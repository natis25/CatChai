<?php
include 'catchai.php';

if (!isset($_GET['id'])) {
    echo "ID de pedido no especificado.";
    exit;
}

$idPedido = $_GET['id'];

// Obtener los detalles del pedido
$queryPedido = "SELECT * FROM Pedido WHERE IdPedido = ?";
$stmt = $conn->prepare($queryPedido);
$stmt->bind_param("i", $idPedido);
$stmt->execute();
$pedido = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Verificar que el pedido existe
if (!$pedido) {
    echo "Pedido no encontrado.";
    exit;
}

// Obtener productos del pedido
$queryProductosPedido = "SELECT PedidoProducto.*, Producto.Producto, Producto.Precio FROM PedidoProducto
                         JOIN Producto ON PedidoProducto.Producto_idProducto = Producto.idProducto
                         WHERE PedidoProducto.Pedido_IdPedido = ?";
$stmtProductos = $conn->prepare($queryProductosPedido);
$stmtProductos->bind_param("i", $idPedido);
$stmtProductos->execute();
$resultProductos = $stmtProductos->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Pedido</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>
    <h1>Editar Pedido</h1>

    <form action="procesar_editar_pedido.php" method="post">
        <input type="hidden" name="idPedido" value="<?php echo $idPedido; ?>">
        <table>
            <tr>
                <th>Producto</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
            <?php
            $total = 0;
            while ($row = $resultProductos->fetch_assoc()) {
                $subtotal = $row['Precio'] * $row['Cantidad'];
                $total += $subtotal;
                echo "<tr>
                        <td>{$row['Producto']}</td>
                        <td>\${$row['Precio']}</td>
                        <td>
                            <input type='number' name='productos[{$row['Producto_idProducto']}]' value='{$row['Cantidad']}' min='0'>
                        </td>
                        <td>\${$subtotal}</td>
                    </tr>";
            }
            $stmtProductos->close();
            ?>
        </table>

        <p class="total">Total Actual: $<?php echo number_format($total, 2); ?></p>
        
        <button type="submit">Guardar Cambios</button>
    </form>

    <a href="listar_pedidos.php">Volver a Lista de Pedidos</a>
</body>
</html>
<?php $conn->close(); ?>
