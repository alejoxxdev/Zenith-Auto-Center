<?php include '../conexion.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login </title>
    <link rel="stylesheet" href="../Stylos-Barra-Navegacion/Login.css">
</head>
<body>
    <div class="contenedor-principal">
        <!--BARRA DE NAVEGACION CON LOGO-->
        <?php include 'header.php'; ?>
        <!--FIN BARRA DE NAVEGACION PARA CELULAR--> 
        <div class="login-container">
            <h1>Login</h1>
            <form action="login.php" method="POST">
                <div class="input-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" placeholder="Ingrese su usuario" required>
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
                <p class="signup-link">¿No tienes una cuenta? <a href="registrar.php">Registrarse</a></p>
            </form>
        </div>
    </div>


</body>
<?php include 'footer.php'; ?>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST['username'];
        $password = $_POST['password'];

        // Preparar la consulta SQL para obtener el usuario
        $sql = "SELECT * FROM login WHERE username = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Verificar la contraseña
            if (password_verify($password, $row['password'])) {
                // Inicio de sesión exitoso
                session_start();
                $_SESSION['id_user'] = $row['id_user'];
                $_SESSION['username'] = $usuario;
                $_SESSION['is_admin'] = $row['is_admin']; // Guardar el estado de administrador en la sesión
                echo "<script>alert('Inicio de sesión exitoso.'); window.location.href='../index.php';</script>";
            } else {
                echo "<script>alert('Contraseña incorrecta. Inténtalo de nuevo.');</script>";
            }
        } else {
            echo "<script>alert('Usuario no encontrado. Inténtalo de nuevo.');</script>";
        }

        $stmt->close();
    }
?>