<?php
session_start();
include('catchai.php');

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Nombre_usuario = $_POST['Nombre_usuario'];
    $Pass = $_POST['Pass'];
    $confirm_Pass = $_POST['confirm_Pass'];
    $Nombre = $_POST['Nombre'];

    if (empty($Nombre_usuario) || empty($Pass) || empty($confirm_Pass) || empty($Nombre)) {
        $error = 'Todos los campos son obligatorios.';
    } elseif ($Pass !== $confirm_Pass) {
        $error = 'Las contraseñas no coinciden.';
    } elseif (!preg_match("/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/", $Pass)) {
        $error = "La contraseña debe tener al menos 8 caracteres, incluir al menos un número y una letra mayúscula";
    } else {
        // p/ ncriptar la Pass para mayor seguridad
        //$Pass = password_hash($Pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO cliente (Nombre, Nombre_usuario, Pass, trabajador, administrador) VALUES (?, ?, ?, '0', '0')";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $Nombre, $Nombre_usuario, $Pass);

            if ($stmt->execute()) {
                $success = 'Cuenta creada exitosamente.';
            } else {
                $error = 'Error al crear la cuenta. Inténtalo de nuevo.';
            }

            $stmt->close();
        } else {
            $error = 'Error de conexión con la base de datos.';
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LogIn.css">
    <title>Crear Cuenta</title>
</head>

<body>

    <form action="crearcuenta.php" method="post">
        <h1>Crear Cuenta Nueva </h1>

        <hr>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="error"><?php echo $success; ?></p>
        <?php endif; ?>
        <hr>

        <label for="Nombre">Nombre Completo:</label>
        <input type="text" name="Nombre" placeholder="Nombre Completo" id="Nombre" required>
        <br>

        <label for="Nombre_usuario">Usuario:</label>
        <input type="text" name="Nombre_usuario" placeholder="Nombre de Usuario" id="Nombre_usuario" required>
        <br>

        <label for="Pass">Contraseña:</label>
        <input type="password" name="Pass" placeholder="Contraseña" id="Pass" required>
        <br>

        <label for="confirm_Pass">Confirmar Contraseña:</label>
        <input type="password" name="confirm_Pass" placeholder="Confirmar Contraseña" id="confirm_Pass" required>
        <br>

        <button type="submit" class="btn">Registrar</button>
        <br><br>
        <a href="index.php">Volver</a>
    </form>
</body>

</html>
