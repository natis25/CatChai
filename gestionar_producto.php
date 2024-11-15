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

    <?php
    if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'producto_actualizado') {
        echo "<p class='mensaje-exito'>Producto actualizado correctamente.</p>";
    } elseif (isset($_GET['mensaje']) && $_GET['mensaje'] == 'producto_agregado') {
        echo "<p class='mensaje-exito'>Producto agregado correctamente.</p>";
    }
    ?>

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

    <!-- Tabla de productos existentes con opciones de edición -->
    <h2>Productos Existentes</h2>
    <table>
        <tr>
            <th>ID</th>
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
                    <form action='procesar_producto.php' method='post'>
                        <input type='hidden' name='accion' value='editar'>
                        <input type='hidden' name='id_producto' value='{$row['idProducto']}'>
                        <td>{$row['idProducto']}</td>
                        <td><input type='text' name='producto' value='{$row['Producto']}' required></td>
                        <td><input type='number' step='0.01' name='precio' value='{$row['Precio']}' required></td>
                        <td><textarea name='descripcion' required>{$row['Descripcion']}</textarea></td>
                        <td><input type='number' name='disponibilidad' min='0' value='{$row['Disponibilidad']}' required></td>
                        <td>
                            <select name='categoria' required>";
                            
            $categoria_query = "SELECT * FROM Categoria";
            $categoria_result = $conn->query($categoria_query);
            while ($categoria_row = $categoria_result->fetch_assoc()) {
                $selected = ($categoria_row['idCategoria'] == $row['Categoria_idCategoria']) ? "selected" : "";
                echo "<option value='{$categoria_row['idCategoria']}' $selected>{$categoria_row['Categoria']}</option>";
            }
            echo "      </select>
                        </td>
                        <td><button type='submit'>Guardar</button></td>
                    </form>
                </tr>";
        }

        $conn->close();
        ?>
    </table>

    <a href="Home.php">Volver al Inicio</a>

</body>
</html>
