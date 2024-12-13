<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="promociones.css">

</head>

<body>
    <h1>Gestionar Categorías</h1>

    <?php
    session_start();

    // Muestra el mensaje si está definido
    if (isset($_SESSION['mensaje'])) {
        echo "<p class='error'>" . htmlspecialchars($_SESSION['mensaje']) . "</p>";
        unset($_SESSION['mensaje']); // Borra el mensaje después de mostrarlo
    }
    ?>


    <h2>Añadir Categoría</h2>
    <form action="procesar_categoria.php" method="post">
        <input type="hidden" name="accion" value="agregar">
        <label for="categoria">Nombre de la Categoría:</label>
        <input type="text" name="categoria" id="categoria" required>
        <button class="btn" type="submit">Añadir Categoría</button>
    </form>

    <h2>Categorías Existentes</h2>
    <table>
        <tr>
            <th>Nombre de la Categoría</th>
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>
        <?php
        include 'catchai.php';
        $query = "SELECT * FROM Categoria";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['Categoria']}</td>
                    <td>
                        <form action='' method='post' style='display:inline;'>
                            <input type='hidden' name='id_categoria' value='{$row['idCategoria']}'>
                            <button class='btn-modificar' type='submit' name='accion' value='editar'>Modificar</button>
                        </form>
                    </td>
                    <td>
                        <form action='' method='post' style='display:inline;'>
                            <input type='hidden' name='id_categoria' value='{$row['idCategoria']}'>
                            <button class='btn-eliminar'type='submit' name='accion' value='eliminar'>Eliminar</button>
                        </form>
                    </td>
                </tr>";
        }

        $conn->close();
        ?>
    </table>


    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'editar') {
        $id_categoria = $_POST['id_categoria'];
    ?>
        <h2>Modificar Categoría</h2>
        <form action="procesar_categoria.php" method="post">
            <input type="hidden" name="accion" value="modificar">
            <input type="hidden" name="id_categoria" value="<?php echo $id_categoria; ?>">
            <label for="nueva_categoria">Nuevo Nombre de la Categoría:</label>
            <input type="text" name="nueva_categoria" id="nueva_categoria" required>
            <button class="btn" type="submit">Guardar Cambios</button>
        </form>
    <?php
    }
    ?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'eliminar') {
        $id_categoria = $_POST['id_categoria'];
    ?>
        <h2>Eliminar Categoría</h2>
        <form action="procesar_categoria.php" method="post">
            <input type="hidden" name="accion" value="eliminar">
            <input type="hidden" name="id_categoria" value="<?php echo $id_categoria; ?>">
            <label for="eliminar_categoria">¿Esta seguro de eliminar la categoria?</label>
            <button class="btn" type="submit">Eliminar Categoría</button>
        </form>
    <?php
    }
    ?>

    <a href="Home.php">Volver al Inicio</a>

</body>

</html>
