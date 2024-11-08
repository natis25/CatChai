<?php
    session_start();
    include('conexion.php');

    $error = '';
    $success = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre_usuario = $_POST['nombre_usuario'];
        $clave = $_POST['clave'];
        $confirm_clave = $_POST['confirm_clave'];
        $nombre_completo = $_POST['nombre_completo'];

        if (empty($nombre_usuario) || empty($clave) || empty($confirm_clave) || empty($nombre_completo)) {
            $error = 'Todos los campos son obligatorios.';
        } elseif ($clave !== $confirm_clave) {
            $error = 'Las contraseñas no coinciden.';
        } elseif (!preg_match("/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/", $clave)) {
            $error = "La contraseña debe tener al menos 8 caracteres, incluir al menos un número y una letra mayúscula";
        } else {
            // p/ ncriptar la clave para mayor seguridad
            //$clave = password_hash($clave, PASSWORD_DEFAULT);
            $sql = "INSERT INTO persona (nombre_completo, nombre_usuario, clave, trabajador, administrador) VALUES (?, ?, ?, '0', '0')";
            
            if ($stmt = $conexion->prepare($sql)) {
                $stmt->bind_param("sss", $nombre_completo, $nombre_usuario, $clave);

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

        $conexion->close();
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
    

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form action="crearcuenta.php" method="post">
        <h1>Crear Cuenta Nueva </h1>

        <label for="nombre_completo">Nombre Completo:</label>
        <input type="text" name="nombre_completo" placeholder="Nombre Completo" id="nombre_completo" required >
        <br>
        
        <label for="nombre_usuario">Usuario:</label>
        <input type="text" name="nombre_usuario" placeholder="Nombre de Usuario" id="nombre_usuario" required>
        <br>
        
        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" placeholder="Contraseña" id="clave" required>
        <br>
        
        <label for="confirm_clave">Confirmar Contraseña:</label>
        <input type="password" name="confirm_clave" placeholder="Confirmar Contraseña" id="confirm_clave" required>
        <br>

        <button type="submit" class="btn">Registrar</button>
        <a href="index.php">Volver</a>
    </form>
</body>
</html>
