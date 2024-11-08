<?php   
    session_start();
    include('Conexion.php');

    if (isset($_POST['nombre_usuario']) && isset($_POST['clave'])) {

        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $nombre_usuario = validate($_POST['nombre_usuario']);
        $clave = validate($_POST['clave']);

        if (empty($nombre_usuario)) {
            header("Location: Index.php?error=El Usuario Es Requerido");
            exit();
        }elseif (empty($clave)) {
            header("Location: Index.php?error=La clave Es Requerida");
            exit();
        }else{

            $sql = "SELECT * FROM persona WHERE nombre_usuario = '$nombre_usuario' AND clave='$clave'";
            $result = mysqli_query($conexion, $sql);

            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                if ($row['nombre_usuario'] === $nombre_usuario && $row['clave'] === $clave) {
                    $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
                    $_SESSION['nombre_completo'] = $row['nombre_completo'];
                    $_SESSION['id'] = $row['id'];
                    header("Location: Inicio.php");
                    exit();
                } else {
                    header("Location: Index.php?error=El usuario o la clave son incorrectas");
                    exit();
                }
            } else {
                header("Location: Index.php?error=El usuario o la clave son incorrectas");
                exit();
            }
        }
    } else {
        header("Location: Index.php");
        exit();
    }
?>
