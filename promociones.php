<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="promociones.css">
    <title>Gestión de Promociones</title>
</head>

<body>

    <?php
    session_start();
    if (isset($_SESSION['mensaje'])): ?>
        <p><?= htmlspecialchars($_SESSION['mensaje']); ?></p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <!-- Formulario para añadir una promoción -->
    <h1>Añadir una Promoción</h1>
    <?php
    $fecha_actual = date('Y-m-d'); // Obtiene la fecha actual en formato YYYY-MM-DD
    ?>
    <form action="procesar_promocion.php" method="post">
        <label for="descuento">Descuento:</label>
        <input type="text" name="descuento" id="descuento" required>

        <label for="porcentaje">Porcentaje:</label>
        <input type="number" name="porcentaje" id="porcentaje" min="0" max="100" required>

        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" min="<?= $fecha_actual; ?>" required>

        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" name="fecha_fin" id="fecha_fin" min="<?= $fecha_actual; ?>" required>

        <button class="btn" type="submit" name="accion" value="crear">Añadir Promoción</button>
    </form>

    <!-- Lista de promociones existentes -->
    <h1>Promociones Actuales</h1>
    <table class="promociones">
        <thead>
            <tr>
                <th>Descuento</th>
                <th>Porcentaje</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Modificar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'catchai.php';

            if ($conn) {
                $query = "SELECT * FROM Descuentos";
                $result = $conn->query($query);

                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Descuento']); ?></td>
                        <td><?= htmlspecialchars($row['Porcentaje']); ?>%</td>
                        <td><?= htmlspecialchars($row['FechaInicio']); ?></td>
                        <td><?= htmlspecialchars($row['FechaFin']); ?></td>
                        <td>
                            <form action="" method="post" style="display:inline;">
                                <input type="hidden" name="id_descuento" value="<?= htmlspecialchars($row['IdDescuentos']); ?>">
                                <button type="submit" name="accion" value="editar">Modificar</button>
                            </form>
                        </td>
                        <td>
                            <form action="procesar_promocion.php" method="post" style="display:inline;" onsubmit="return confirmarEliminacion();">
                                <input type="hidden" name="id_descuento" value="<?= htmlspecialchars($row['IdDescuentos']); ?>">
                                <input type="hidden" name="accion" value="eliminar">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
            <?php endwhile;

                $conn->close();
            } else {
                echo "<tr><td colspan='5'>Error al conectar con la base de datos.</td></tr>";
            }
            ?>

            <script>
                function confirmarEliminacion() {
                return confirm("¿Está seguro de que desea eliminar esta promoción?");
                }
            </script>

        </tbody>
    </table>

    <!-- Formulario para editar una promoción -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'editar'):
        $id_descuento = intval($_POST['id_descuento']);
        include 'catchai.php';

        $query = "SELECT * FROM Descuentos WHERE IdDescuentos = $id_descuento";
        $result = $conn->query($query);

        if ($row = $result->fetch_assoc()):
    ?>
            <h2>Modificar Promoción</h2>
            <form action="procesar_promocion.php" method="post">
                <input type="hidden" name="accion" value="editar"> <!-- El valor debe coincidir con el `case` -->
                <input type="hidden" name="id_descuento" value="<?= htmlspecialchars($id_descuento); ?>">

                <label for="nuevo_descuento">Nombre de Descuento:</label>
                <input type="text" name="descuento" id="nuevo_descuento" value="<?= htmlspecialchars($row['Descuento']); ?>" required>

                <label for="nuevo_porcentaje">Porcentaje:</label>
                <input type="number" name="porcentaje" id="nuevo_porcentaje" value="<?= htmlspecialchars($row['Porcentaje']); ?>" min="0" max="100" required>

                <label for="nueva_inicio">Fecha de Inicio:</label>
                <input type="date" name="fecha_inicio" id="nueva_inicio" 
                value="<?= htmlspecialchars($row['FechaInicio']); ?>" 
                min="<?= $fecha_actual; ?>" required>

                <label for="nuevo_fin">Fecha de Fin:</label>
                <input type="date" name="fecha_fin" id="nuevo_fin" 
                value="<?= htmlspecialchars($row['FechaFin']); ?>" 
                min="<?= $fecha_actual; ?>" required>

                <button class="btn" type="submit">Guardar Cambios</button>
            </form>
    <?php
        else:
            echo "<p>Error: No se encontró la promoción.</p>";
        endif;

        $conn->close();
    endif;
    ?>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'elimar'):
        $id_descuento = intval($_POST['id_descuento']);
        include 'catchai.php';

        $query = "SELECT * FROM Descuentos WHERE IdDescuentos = $id_descuento";
        $result = $conn->query($query);

        if ($row = $result->fetch_assoc()):
    ?>

    <?php
        else:
            echo "<p>Error: No se encontró la promoción.</p>";
        endif;

        $conn->close();
    endif;
    ?>

    <a href="Home.php">Volver al Inicio</a>

</body>

</html>