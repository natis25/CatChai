<?php
session_start();
include('catchai.php');

if (isset($_POST['Nombre_usuario']) && isset($_POST['Pass'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $Nombre_usuario = validate($_POST['Nombre_usuario']);
    $Pass = validate($_POST['Pass']);

    if (empty($Nombre_usuario)) {
        header("Location: Index.php?error=El Usuario Es Requerido");
        exit();
    } elseif (empty($Pass)) {
        header("Location: Index.php?error=La contraseña Es Requerida");
        exit();
    } else {

        $sql = "SELECT * FROM cliente WHERE Nombre_usuario = '$Nombre_usuario' AND Pass='$Pass'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['Nombre_usuario'] === $Nombre_usuario && $row['Pass'] === $Pass) {
                // Corregir el nombre de la clave de sesión para IdPersona
                $_SESSION['Nombre_usuario'] = $row['Nombre_usuario'];
                $_SESSION['Nombre'] = $row['Nombre'];
                $_SESSION['IdPersona'] = $row['IdPersona']; // CORRECCIÓN: Sin espacio al final
                $_SESSION['Trabajador'] = $row['Trabajador'];
                $_SESSION['Administrador'] = $row['Administrador'];

                // Redirigir según el rol del usuario
                if ($row['Administrador'] == 1) {
                    header("Location: Home.php"); // Redirige al menú completo
                } elseif ($row['Trabajador'] == 1) {
                    header("Location: Home.php"); // Redirige al menú completo
                } else {
                    header("Location: pedidos.php"); // Redirige al menú para hacer un nuevo pedido
                }

                exit();
            } else {
                header("Location: Index.php?error=El usuario o la contraseña son incorrectas");
                exit();
            }
        } else {
            header("Location: Index.php?error=El usuario o la contraseña son incorrectas");
            exit();
        }
    }
} else {
    header("Location: Index.php");
    exit();
}
?>
