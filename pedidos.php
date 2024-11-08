<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Pedidos</title>
</head>
<body>
    <h1>Gestión de Pedidos</h1>
    
    <!-- Formulario para agregar un pedido -->
    <form action="procesar_pedido.php" method="post">
        <label for="cliente_id">ID Cliente:</label>
        <input type="number" name="cliente_id" id="cliente_id" required>
        
        <label for="descuento_id">ID Descuento (opcional):</label>
        <input type="number" name="descuento_id" id="descuento_id">
        
        <label for="precio_total">Precio Total:</label>
        <input type="number" name="precio_total" id="precio_total" required>
        
        <label for="fecha_entrega">Fecha de Entrega:</label>
        <input type="date" name="fecha_entrega" id="fecha_entrega" required>
        
        <label for="hora_entrega">Hora de Entrega:</label>
        <input type="time" name="hora_entrega" id="hora_entrega" required>
        
        <button type="submit" name="accion" value="agregar">Agregar Pedido</button>
        <button type="submit" name="accion" value="cancelar">Cancelar Pedido</button>
    </form>
</body>
</html>
