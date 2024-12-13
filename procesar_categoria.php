<?php

session_start();
include 'catchai.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];
    
    if ($accion === 'agregar') {
        // Validar y agregar la categoría
        $categoria = trim($_POST['categoria']);
        if (empty($categoria)) {
            $_SESSION['mensaje'] = "El nombre de la categoría no puede estar vacío.";
        } else {
            $stmt = $conn->prepare("INSERT INTO Categoria (Categoria) VALUES (?)");
            $stmt->bind_param("s", $categoria);
            if ($stmt->execute()) {
                $_SESSION['mensaje'] = "Categoría añadida correctamente.";
            } else {
                $_SESSION['mensaje'] = "Error al añadir la categoría: " . $conn->error;
            }
            $stmt->close();
        }
    } elseif ($accion === 'eliminar') {
        
        $id_categoria = (int)$_POST['id_categoria'];
        if ($id_categoria <= 0) {
            $_SESSION['mensaje'] = "ID de categoría inválido.";
        } else {
            $stmt = $conn->prepare("DELETE FROM Categoria WHERE idCategoria = ?");
            $stmt->bind_param("i", $id_categoria);
            if ($stmt->execute()) {
                $_SESSION['mensaje'] = "Categoría eliminada correctamente.";
            } else {
                $_SESSION['mensaje'] = "Error al eliminar la categoría: " . $conn->error;
            }
            $stmt->close();
        }
    }

    elseif ($accion === 'modificar') {
        
        $id_categoria = (int)$_POST['id_categoria'];
        $nueva_categoria = trim($_POST['nueva_categoria']);
        
        if ($id_categoria > 0 && !empty($nueva_categoria)) {
            $stmt = $conn->prepare("UPDATE Categoria SET Categoria = ? WHERE idCategoria = ?");
            $stmt->bind_param("si", $nueva_categoria, $id_categoria);
            if ($stmt->execute()) {
                $_SESSION['mensaje'] = "Categoría modificada correctamente.";
            } else {
                $_SESSION['mensaje'] = "Error al modificar la categoría: " . $conn->error;
            }
            $stmt->close();
        } else {
            $_SESSION['mensaje'] = "ID o nombre de categoría inválidos.";
        }
    }

    $conn->close();
    header("Location: agregar_categoria.php");
    exit;
}
?>
