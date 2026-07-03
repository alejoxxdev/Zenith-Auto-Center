<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Bienvenido </title>
</head>
<body>

    <?php
    include 'conexion.php';
    session_start();

    $usuario_login = 'invitado';
    if (isset($_SESSION['username'])) {
        $id_user = $_SESSION['username'];
        $usuario_login = $id_user;
    }

    ?>
    <h1>Bienvenido, Ingreso exitoso</h1>
    <?php echo htmlspecialchars($usuario_login); ?>
    <br>
    <a href="cerrar_sesion.php">Cerrar Sesion</a>
</body>
</html>