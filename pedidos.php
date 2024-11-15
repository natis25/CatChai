<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="pedidos.css">
    <title>Nuevo Pedido</title>

    <script>
        // Función para calcular y mostrar el total
        function calcularTotal() {
            let total = 0;
            let detallePedido = "";
            
            const cantidades = document.querySelectorAll('.cantidad');
            
            cantidades.forEach(cantidad => {
                const precio = parseFloat(cantidad.dataset.precio);
                const producto = cantidad.dataset.producto;
                const max = parseInt(cantidad.max);
                const cant = parseInt(cantidad.value) || 0;

                if (cant > 0) {
                    const subtotal = precio * cant;
                    total += subtotal;

                    // Añadir producto a la tabla de pedido
                    detallePedido += `<tr>
                        <td>${producto}</td>
                        <td>${cant}</td>
                        <td>Bs${precio.toFixed(2)}</td>
                        <td>Bs${subtotal.toFixed(2)}</td>
                    </tr>`;
                }
            });

            // Mostrar el total y el detalle del pedido
            document.getElementById('total').textContent = 'Total: Bs' + total.toFixed(2);
            document.getElementById('detallePedido').innerHTML = detallePedido;
        }
    </script>
</head>
<body>
    <h1>Nuevo Pedido</h1>

    <form action="procesar_pedido.php" method="post">
        <table>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Disponibilidad</th>
                <th>Cantidad</th>
            </tr>
            <?php
            include 'catchai.php';
            $query = "SELECT * FROM Producto WHERE Disponibilidad > 0";
            $result = $conn->query($query);
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['Producto']}</td>
                        <td>Bs{$row['Precio']}</td>
                        <td>{$row['Disponibilidad']}</td>
                        <td>
                            <input type='number' name='productos[{$row['idProducto']}]' class='cantidad' data-precio='{$row['Precio']}' data-producto='{$row['Producto']}' min='0' max='{$row['Disponibilidad']}' value='0' onchange='calcularTotal()'>
                        </td>
                    </tr>";
            }
            $conn->close();
            ?>
        </table>

        <p class="total" id="total">Total: Bs 0.00</p>
        <button class="btn" type="submit">Confirmar Pedido</button>
    </form>

    <!-- Tabla de detalles del pedido -->
    <h1>Productos en el Pedido</h1>
    <table id="detallePedidoTable">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody id="detallePedido">
            <!-- Aquí se llenarán los productos seleccionados -->
        </tbody>
    </table>

    <a href="Home.php">Volver al Inicio</a>
</body>
</html>
