<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="promociones.css">

    <title>Gestionar Productos</title>
    <style>
        body {
            background: url('Images/gestionar_producto_background.webp') no-repeat center center/cover;
        }
    </style>
</head>

<body>
    <h1>Gestionar Productos</h1>

    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'producto_actualizado') { ?>
        <p class="error"><?php echo "Producto actualizado correctamente."; ?></p>
    <?php } elseif (isset($_GET['mensaje']) && $_GET['mensaje'] == 'producto_agregado') { ?>
        <p class="error"><?php echo "Producto agregado correctamente."; ?></p>
    <?php } ?>
    <!-- Formulario para añadir un producto -->
    <h2>Añadir Producto</h2>
    <form action="procesar_producto.php" method="post">
        <input type="hidden" name="accion" value="agregar">

        <label for="producto">Nombre del Producto:</label>
        <input type="text" name="producto" id="producto" required>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" id="precio" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required></textarea>

        <label for="disponibilidad">Disponibilidad:</label>
        <input type="number" name="disponibilidad" id="disponibilidad" min="0" required>

        <label for="categoria">Categoría:</label>
        <select name="categoria" id="categoria" required>
            <option value="">Seleccione una categoría</option>
            <?php
            include 'catchai.php';
            $query = "SELECT * FROM Categoria";
            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['idCategoria']}'>{$row['Categoria']}</option>";
            }

            $conn->close();
            ?>
        </select>

        <button class="btn" type="submit">Añadir Producto</button>
    </form>

    <h2>Productos Existentes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre del Producto</th>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Disponibilidad</th>
            <th>Categoría</th>
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>
        <?php
            include 'catchai.php';
            $query = "SELECT p.idProducto, p.Producto, p.Precio, p.Descripcion, p.Disponibilidad, c.Categoria, p.Categoria_idCategoria 
            FROM Producto p 
            JOIN Categoria c ON p.Categoria_idCategoria = c.idCategoria";
            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()) {
                    echo "<tr data-id='{$row['idProducto']}'>
                        <td>{$row['idProducto']}</td>
                        <td>{$row['Producto']}</td>
                        <td>{$row['Precio']}</td>
                        <td>{$row['Descripcion']}</td>
                        <td>{$row['Disponibilidad']}</td>
                        <td>{$row['Categoria']}</td>
                        <td><a href='gestionar_producto.php?id_producto={$row['idProducto']}' class='edit-btn'>Modificar</a></td>
                        <td>
                            <form action='procesar_producto.php' method='post' onsubmit='return confirmDelete()'>
                            <input type='hidden' name='accion' value='eliminar'>
                            <input type='hidden' name='id_producto' value='{$row['idProducto']}'>
                            <button type='submit' class='delete-btn'>Eliminar</button>
                            </form>
                        </td>
                        </tr>";
            }
            $conn->close();
        ?>
    </table>

    <!-- Formulario de modificación (inicialmente oculto) -->
<div id="edit-form-container" style="display: none;">
    <h2>Modificar Producto</h2>
    <form id="edit-form" action="procesar_producto.php" method="post">
        <input type="hidden" name="accion" value="editar">
        <input type="hidden" name="id_producto" id="edit-id_producto">
        
        <label for="edit-producto">Nombre del Producto:</label>
        <input type="text" name="producto" id="edit-producto" required>

        <label for="edit-precio">Precio:</label>
        <input type="number" step="0.01" name="precio" id="edit-precio" required>

        <label for="edit-descripcion">Descripción:</label>
        <textarea name="descripcion" id="edit-descripcion" required></textarea>

        <label for="edit-disponibilidad">Disponibilidad:</label>
        <input type="number" name="disponibilidad" id="edit-disponibilidad" min="0" required>

        <label for="edit-categoria">Categoría:</label>
        <select name="categoria" id="edit-categoria" required>
            <option value="">Seleccione una categoría</option>
            <?php
            include 'catchai.php';
            $categoria_query = "SELECT * FROM Categoria";
            $categoria_result = $conn->query($categoria_query);
            while ($categoria_row = $categoria_result->fetch_assoc()) {
                echo "<option value='{$categoria_row['idCategoria']}'>{$categoria_row['Categoria']}</option>";
            }
            ?>
        </select>

        <button type="submit">Guardar Cambios</button>
    </form>
    <button onclick="cancelEdit()">Cancelar</button>
</div>

<script>
    // Mostrar el formulario de edición con los datos del producto
    function editProduct(id) {
        // Obtener los datos del producto (se pueden obtener usando Ajax o incluyendo todos los datos en un atributo)
        var row = document.querySelector("tr[data-id='" + id + "']");
        var producto = row.querySelector(".producto").textContent;
        var precio = row.querySelector(".precio").textContent;
        var descripcion = row.querySelector(".descripcion").textContent;
        var disponibilidad = row.querySelector(".disponibilidad").textContent;
        var categoria = row.querySelector(".categoria").textContent;

        // Rellenar el formulario de edición con los datos del producto
        document.getElementById("edit-id_producto").value = id;
        document.getElementById("edit-producto").value = producto;
        document.getElementById("edit-precio").value = precio;
        document.getElementById("edit-descripcion").value = descripcion;
        document.getElementById("edit-disponibilidad").value = disponibilidad;
        document.getElementById("edit-categoria").value = categoria;

        // Mostrar el formulario de edición
        document.getElementById("edit-form-container").style.display = "block";
    }

    // Función para cancelar la edición
    function cancelEdit() {
        document.getElementById("edit-form-container").style.display = "none";
    }
</script>

    <a href="Home.php">Volver al Inicio</a>

</body>

</html>
