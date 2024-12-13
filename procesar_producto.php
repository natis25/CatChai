<?php
include 'catchai.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];

    
    if ($accion == 'agregar') {
        $producto = trim($_POST['producto']);
        $precio = (float)$_POST['precio'];
        $descripcion = trim($_POST['descripcion']);
        $disponibilidad = (int)$_POST['disponibilidad'];
        $categoria_id = (int)$_POST['categoria'];

        if (empty($producto) || empty($descripcion) || $precio <= 0 || $disponibilidad < 0 || $categoria_id <= 0) {
            echo "Todos los campos deben estar correctamente llenos y con valores válidos.";
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO Producto (Producto, Precio, Descripcion, Disponibilidad, Categoria_idCategoria) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsii", $producto, $precio, $descripcion, $disponibilidad, $categoria_id);

        if ($stmt->execute()) {
            header("Location: gestionar_producto.php?mensaje=producto_agregado");
            exit;
        } else {
            echo "Error al añadir el producto: " . $conn->error;
        }

        $stmt->close();

    
    } elseif ($accion == 'editar') {
        $id_producto = (int)$_POST['id_producto'];
        $producto = trim($_POST['producto']);
        $precio = (float)$_POST['precio'];
        $descripcion = trim($_POST['descripcion']);
        $disponibilidad = (int)$_POST['disponibilidad'];
        $categoria_id = (int)$_POST['categoria'];

        
        if (empty($producto) || empty($descripcion) || $precio <= 0 || $disponibilidad < 0 || $categoria_id <= 0) {
            echo "Todos los campos deben estar correctamente llenos y con valores válidos.";
            exit;
        }

        
        $stmt = $conn->prepare("UPDATE Producto SET Producto = ?, Precio = ?, Descripcion = ?, Disponibilidad = ?, Categoria_idCategoria = ? WHERE idProducto = ?");
        $stmt->bind_param("sdsiii", $producto, $precio, $descripcion, $disponibilidad, $categoria_id, $id_producto);

        if ($stmt->execute()) {
            header("Location: gestionar_producto.php?mensaje=producto_actualizado");
            exit;
        } else {
            echo "Error al actualizar el producto: " . $conn->error;
        }

        $stmt->close();
    
    } elseif ($accion == 'eliminar' && isset($_POST['id_producto'])) {
        $id_producto = (int)$_POST['id_producto'];
        $stmt = $conn->prepare("DELETE FROM Producto WHERE idProducto = ?");
        $stmt->bind_param("i", $id_producto);

        if ($stmt->execute()) {
            header("Location: gestionar_producto.php?mensaje=producto_eliminado");
            exit;
        } else {
            echo "Error al eliminar el producto: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
