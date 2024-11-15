<?php
// Incluye el archivo de conexión a la base de datos
include 'catchai.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar la entrada
    $categoria = trim($_POST['categoria']);

    // Verifica si el campo está vacío
    if (empty($categoria)) {
        echo "El nombre de la categoría no puede estar vacío.";
        exit;
    }

    // Preparar la consulta SQL para evitar inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO Categoria (Categoria) VALUES (?)");
    $stmt->bind_param("s", $categoria);

    // Ejecuta la consulta y verifica si se ejecutó correctamente
    if ($stmt->execute()) {
        echo "Categoría añadida correctamente.";
    } else {
        echo "Error al añadir la categoría: " . $conn->error;
    }

    // Cierra la conexión
    $stmt->close();
    $conn->close();
}
?>
