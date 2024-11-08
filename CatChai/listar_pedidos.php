<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar Pedidos</title>
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
    </style>
</head>
<body>
    <h1>Lista de Pedidos</h1>

    <table>
        <tr>
            <th>ID Pedido</th>
            <th>Fecha Pedido</th>
            <th>Hora Pedido</th>
            <th>Precio Total</th>
            <th>Acciones</th>
        </tr>
        <?php
        include 'catchai.php';
        $query = "SELECT * FROM Pedido";
        $result = $conn->query($query);
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['IdPedido']}</td>
                    <td>{$row['FechaPedido']}</td>
                    <td>{$row['HoraPedido']}</td>
                    <td>\${$row['PrecioTotal']}</td>
                    <td>
                        <a href='editar_pedido.php?id={$row['IdPedido']}'>Editar</a> | 
                        <a href='eliminar_pedido.php?id={$row['IdPedido']}' onclick='return confirm(\"¿Estás seguro de eliminar este pedido?\")'>Eliminar</a>
                    </td>
                </tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
