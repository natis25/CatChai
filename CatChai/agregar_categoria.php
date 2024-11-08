<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Categorías</title>
    <style>
        table {
            width: 50%;
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
    <h1>Gestionar Categorías</h1>

    <!-- Formulario para añadir una categoría -->
    <h2>Añadir Categoría</h2>
    <form action="procesar_categoria.php" method="post">
        <input type="hidden" name="accion" value="agregar">
        <label for="categoria">Nombre de la Categoría:</label>
        <input type="text" name="categoria" id="categoria" required>
        <button type="submit">Añadir Categoría</button>
    </form>

    <!-- Formulario para eliminar una categoría -->
    <h2>Eliminar Categoría</h2>
    <form action="procesar_categoria.php" method="post">
        <input type="hidden" name="accion" value="eliminar">
        <label for="id_categoria">ID de la Categoría:</label>
        <input type="number" name="id_categoria" id="id_categoria" required>
        <button type="submit">Eliminar Categoría</button>
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
</body>
</html>
