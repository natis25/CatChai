<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="pedidos.css">
    <title>Listar Pedidos</title>
</head>

<body>
    <h1>Lista de Pedidos Pendientes</h1>

    <table>
        <tr>
            <th>Cliente</th>
            <th>Fecha Pedido</th>
            <th>Hora Pedido</th>
            <th>Precio Total</th>
            <th>Acciones</th>
        </tr>
        <?php
        include 'catchai.php';

        // Consulta con JOIN para obtener solo los pedidos con Estado = false
        $query = "SELECT Pedido.IdPedido, Pedido.FechaPedido, Pedido.HoraPedido, Pedido.PrecioTotal, 
                        Cliente.Nombre AS NombreCliente 
                FROM Pedido
                JOIN Cliente ON Pedido.Cliente_IdPersona = Cliente.IdPersona
                  WHERE Pedido.Estado = 0"; // Filtra los pedidos no confirmados (Estado = false)

        $result = $conn->query($query);

        // Recorre los resultados y genera las filas de la tabla
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['NombreCliente']}</td>
                    <td>{$row['FechaPedido']}</td>
                    <td>{$row['HoraPedido']}</td>
                    <td>Bs{$row['PrecioTotal']}</td>
                    <td>
                        <button class='btn-mostrar' onclick=\"location.href='mostrar_pedido.php?id={$row['IdPedido']}'\">Mostrar</button>
                        <button class='btn-mostrar' onclick=\"location.href='confirmar_pedido.php?id={$row['IdPedido']}'\">Confirmar</button>
                        <button class='btn-modificar' onclick=\"location.href='editar_pedido.php?id={$row['IdPedido']}'\">Editar</button>
                        <button class='btn-eliminar' onclick=\"return confirm('¿Estás seguro de cancelar este pedido?') ? location.href='eliminar_pedido.php?id={$row['IdPedido']}' : false;\">Cancelar</button>
                    </td>
                </tr>";
        }

        $conn->close();
        ?>
    </table>
    <a href="Home.php">Volver al Inicio</a>
</body>

</html>