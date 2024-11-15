<!DOCTYPE html>
<html lang="es">
<?php
include 'catchai.php'; // Conexión a la base de datos
class Pedido {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function mostrarProductos() {
        $query = "SELECT producto.*, categoria.Categoria 
                  FROM producto 
                  JOIN categoria ON producto.Categoria_idCategoria = categoria.idCategoria 
                  WHERE producto.Disponibilidad > 0 
                  ORDER BY categoria.Categoria";
        $result = $this->conn->query($query);
       
        $categoriaActual = "";
        while ($row = $result->fetch_assoc()) {
            if ($categoriaActual != $row['Categoria']) {
                if ($categoriaActual != "") {
                    echo "</div>"; // Cierra el div anterior de categoría
                }
                $categoriaActual = $row['Categoria'];
                echo "<div class='categoria'><h3>{$categoriaActual}</h3>";
            }
            echo "<div class='producto'>
                    <h4>{$row['Producto']}</h4>
                    <p>{$row['Descripcion']}</p>
                    <p>Precio: Bs{$row['Precio']}</p>
                    <p>Disponibilidad: {$row['Disponibilidad']}</p>
                    <input type='number' class='cantidad' 
                        data-producto='{$row['Producto']}' 
                        data-precio='{$row['Precio']}' 
                        max='{$row['Disponibilidad']}' 
                        value='0' 
                        onchange='calcularTotal()'>
                  </div>";
        }
        echo "</div>"; // Cierra el último div de categoría
    }
}
$pedido = new Pedido($conn);
?>

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

        if (cant > 0 && cant <= max) {
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
        <?php $pedido->mostrarProductos(); ?>
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
