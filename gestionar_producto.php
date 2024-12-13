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
            <th>Nombre del Producto</th>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Disponibilidad</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
        <?php
        include 'catchai.php';
        $query = "SELECT p.idProducto, p.Producto, p.Precio, p.Descripcion, p.Disponibilidad, c.Categoria, p.Categoria_idCategoria 
                FROM Producto p 
                JOIN Categoria c ON p.Categoria_idCategoria = c.idCategoria";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['Producto']}</td>
                    <td>{$row['Precio']}</td>
                    <td>{$row['Descripcion']}</td>
                    <td>{$row['Disponibilidad']}</td>
                    <td>{$row['Categoria']}</td>
                    <td>
                        <button class='btn-modificar' type='button' onclick='mostrarFormulario({$row['idProducto']}, \"{$row['Producto']}\", {$row['Precio']}, \"{$row['Descripcion']}\", {$row['Disponibilidad']}, {$row['Categoria_idCategoria']})'>Modificar</button>
                        <form action='procesar_producto.php' method='post' style='display:inline;'>
                            <input type='hidden' name='accion' value='eliminar'>
                            <input type='hidden' name='id_producto' value='{$row['idProducto']}'>
                            <button class='btn-eliminar' type='submit' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\")'>Eliminar</button>
                        </form>
                    </td>
                </tr>";
        }
        $conn->close();
        ?>
    </table>

    <!-- Formulario de modificar-->
    <div id="formulario-editar">
        <h2>Editar Producto</h2>
        <form action="procesar_producto.php" method="post">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" id="id_producto" name="id_producto">

            <label for="producto_editar">Nombre del Producto:</label>
            <input type="text" id="producto_editar" name="producto" required>

            <label for="precio_editar">Precio:</label>
            <input type="number" step="0.01" id="precio_editar" name="precio" required>

            <label for="descripcion_editar">Descripción:</label>
            <textarea id="descripcion_editar" name="descripcion" required></textarea>

            <label for="disponibilidad_editar">Disponibilidad:</label>
            <input type="number" id="disponibilidad_editar" name="disponibilidad" min="0" required>

            <label for="categoria_editar">Categoría:</label>
            <select id="categoria_editar" name="categoria" required>
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

            <button class="btn" type="submit">Guardar Cambios</button>
        </form>
    </div>

    <a href="Home.php">Volver al Inicio</a>

    <script>
        function mostrarFormulario(id, producto, precio, descripcion, disponibilidad, categoria) {
            document.getElementById('id_producto').value = id;
            document.getElementById('producto_editar').value = producto;
            document.getElementById('precio_editar').value = precio;
            document.getElementById('descripcion_editar').value = descripcion;
            document.getElementById('disponibilidad_editar').value = disponibilidad;
            document.getElementById('categoria_editar').value = categoria;

            document.getElementById('formulario-editar').style.display = 'block';
        }
    </script>

</body>

</html>
