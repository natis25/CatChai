<!DOCTYPE html>
<html lang="es">
<?php
include 'catchai.php'; // Conexión a la base de datos
class Pedido
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function mostrarProductos()
    {
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
                echo "<h3>{$categoriaActual}</h3>";
                echo "<div class='categoria'>";
            }
            echo "<div class='producto'>
                    <h4>{$row['Producto']}</h4>
                    <p>{$row['Descripcion']}</p>
                    <p>Precio: Bs{$row['Precio']}</p>
                    

                    <input type='number' class='cantidad' 
                        data-producto-id='{$row['idProducto']}' 
                        data-producto='{$row['Producto']}'
                        data-idCategoria='{$row['Categoria_idCategoria']}' 
                        data-precio='{$row['Precio']}' 
                        max='{$row['Disponibilidad']}'
                        min='0' 
                        value='0' 
                        onchange='calcularTotal()'>
                        
                </div>";
        }
        echo "</div>"; // Cierra el último div de categoría
    }

    public function mostrarDescuentoActivo()
    {
        $hoy = date('Y-m-d');
        $query = "SELECT * FROM descuentos WHERE FechaInicio <= '$hoy' AND FechaFin >= '$hoy' LIMIT 1";
        $result = $this->conn->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            echo "<div class='producto'>
                <h4 style='border-left: 5px solid rgb(188, 208, 12)'>Descuento Activo</h4>
                <p>Descuento: {$row['Descuento']}</p>
                <p>Porcentaje: {$row['Porcentaje']}%</p>
                <p>Válido desde: {$row['FechaInicio']} hasta: {$row['FechaFin']}</p>
                <input type='hidden' id='porcentajeDescuento' value='{$row['Porcentaje']}'>
            </div>";
        }
    }
}
$pedido = new Pedido($conn);
?>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="pedidos.css">
    <title>Nuevo Pedido</title>

    <script>
    function redondearCercano(numero) {
        return Math.round(numero * 2) / 2;
    }
    
    function calcularTotal() {
        let total = 0;
        let subtotalGeneral = 0; // Subtotal sin descuento
        const descuento = parseFloat(document.getElementById('porcentajeDescuento')?.value || 0);
        const cantidades = document.querySelectorAll('.cantidad');
        const detallePedido = document.getElementById('detallePedido');

        detallePedido.innerHTML = "";

        cantidades.forEach(cantidad => {
            const idProducto = cantidad.dataset.productoId;
            const producto = cantidad.dataset.producto;
            const precio = parseFloat(cantidad.dataset.precio);
            const cant = parseInt(cantidad.value) || 0;

            if (cant > 0) {
                const subtotal = precio * cant;
                subtotalGeneral += subtotal; // Sumar al subtotal general
                total += subtotal;

                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${producto}</td>
                    <td>${cant}</td>
                    <td>Bs${precio.toFixed(2)}</td>
                    <td>Bs${subtotal.toFixed(2)}</td>
                `;

                detallePedido.appendChild(fila);
            }
        });

        // Mostrar el subtotal general sin descuentos
        document.getElementById('subtotal').textContent = `Subtotal: Bs ${subtotalGeneral.toFixed(2)}`;

        // Aplicar descuento si existe
        if (descuento > 0) {
            const descuentoAplicado = subtotalGeneral * (descuento / 100);
            total = subtotalGeneral - descuentoAplicado;
            document.getElementById('descuentoAplicado').textContent = `Descuento aplicado: Bs ${descuentoAplicado.toFixed(2)}`;
        } else {
            document.getElementById('descuentoAplicado').textContent = '';
        }

        total = redondearCercano(total);
        document.getElementById('total').textContent = `Total: Bs ${total.toFixed(2)}`;
    }

    function enviarPedido() {
        const cantidades = document.querySelectorAll('.cantidad');
        const productos = {};

        cantidades.forEach(cantidad => {
            const idProducto = cantidad.dataset.productoId;
            const cant = parseInt(cantidad.value) || 0;

            if (cant > 0) {
                productos[idProducto] = cant;
            }
        });

        document.getElementById('productosSeleccionados').value = JSON.stringify(productos);
    }
</script>


</head>

<body>
    <h1>Nuevo Pedido</h1>

    <?php $pedido->mostrarDescuentoActivo(); ?>

    <form id="pedidoForm" action="procesar_pedido.php" method="post" onsubmit="enviarPedido(); return true;">
        <?php $pedido->mostrarProductos(); ?>
        <input type="hidden" id="productosSeleccionados" name="productos">
        <p class="total" style="color: black" id="subtotal"></p>
        <p class="total" style="color: black" id="descuentoAplicado"></p>
        <p class="total" id="total">Total: Bs 0.00</p>
        <button class="btn" type="submit">Confirmar Pedido</button>
    </form>

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
        </tbody>
    </table>

    <a class="volver" href="CerrarSesion.php">Salir</a>
</body>

</html>
