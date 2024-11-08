<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Promociones</title>
</head>
<body>
    <h1>Promociones</h1>
    <form action="procesar_promocion.php" method="post">
        <input type="hidden" name="id" id="id">
        <label for="descuento">Descuento:</label>
        <input type="text" name="descuento" id="descuento" required>
        
        <label for="porcentaje">Porcentaje:</label>
        <input type="number" name="porcentaje" id="porcentaje" required>
        
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" required>
        
        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" name="fecha_fin" id="fecha_fin" required>
        
        <button type="submit" name="accion" value="crear">Añadir Promoción</button>
        <button type="submit" name="accion" value="editar">Editar Promoción</button>
        <button type="submit" name="accion" value="eliminar">Eliminar Promoción</button>
    </form>
    
    <!-- Lista de promociones existentes -->
    <h2>Promociones Actuales</h2>
    <ul>
        <?php
        include 'catchai.php';
        $query = "SELECT * FROM Descuentos";
        $result = $conn->query($query);
        
        while($row = $result->fetch_assoc()) {
            echo "<li>ID: {$row['IdDescuentos']} - {$row['Descuento']} - {$row['Porcentaje']}% desde {$row['FechaInicio']} hasta {$row['FechaFin']}</li>";
        }
        ?>
    </ul>
</body>
</html>
