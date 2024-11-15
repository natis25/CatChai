<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="promociones.css">
    <title>Gestionar Categorías</title>
</head>

<body>
    <style>
        body {
            background: url('Images/agregar_categoria_background.webp') no-repeat center center/cover;
        }
    </style>
    <h1>Gestionar Categorías</h1>

    <?php
        if (isset($_GET['error'])) {
        ?>
            <p class="error">
                <?php
                echo $_GET['error']
                ?>
            </p>
        <?php
        }
        ?>
    
    <!-- Formulario para añadir una categoría -->
    <h2>Añadir Categoría</h2>
    <form action="procesar_categoria.php" method="post">
        <input type="hidden" name="accion" value="agregar">
        <label for="categoria">Nombre de la Categoría:</label>
        <input type="text" name="categoria" id="categoria" required>
        <button class="btn" type="submit">Añadir Categoría</button>
    </form>

    <!-- Formulario para eliminar una categoría -->
    <h2>Eliminar Categoría</h2>
    <form action="procesar_categoria.php" method="post">
        <input type="hidden" name="accion" value="eliminar">
        <label for="id_categoria">ID de la Categoría:</label>
        <input type="number" name="id_categoria" id="id_categoria" required>
        <button class="btn" type="submit">Eliminar Categoría</button>
    </form>

    <!-- Tabla de categorías existentes -->
    <h2>Categorías Existentes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre de la Categoría</th>
        </tr>
        <?php
        include 'catchai.php';
        $query = "SELECT * FROM Categoria";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['idCategoria']}</td>
                    <td>{$row['Categoria']}</td>
                </tr>";
        }

        $conn->close();
        ?>
    </table>

    <a href="Home.php">Volver al Inicio</a>

</body>

</html>