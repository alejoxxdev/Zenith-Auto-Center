<?php include '../conexion.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="../Stylos-Barra-Navegacion/Login.css">

</head>
<body>
    <?php include 'header.php'; ?>
    <div class="contenedor-principal"> 
        <div class="login-container">
            <h1>Registrar</h1>
            <form action="registrar.php" method="post">
                <div class="input-group">
                    <label for="username"> Usuario</label>
                    <input type="text" id="username" name="username" placeholder="Ingresa su usuario" required>
                </div>
                <div class="input-group">
                    <label for="password"> Contraseña </label>
                    <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
                </div>
                <div class="input-group">
                    <label for="password"> Confirmar contraseña </label>
                    <input type="password" id="password" name="confirmar_password" placeholder="Ingrese de nuevo su contraseña" required>
                </div>
                <button type="submit" class="login-btn">Sign Up</button>
                <p class="signup-link">you have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
<?php include'footer.php';?>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['username'];
    $password = $_POST['password'];
    $confirmar_password = $_POST['confirmar_password'];

    if ($password === $confirmar_password) {
        // Hashear la contraseña
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Preparar la consulta SQL para insertar el nuevo usuario
        $sql = "INSERT INTO login (username, password, is_admin) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $is_admin = 0; // Valor por defecto para is_admin
        $stmt->bind_param("ssi", $usuario, $hashed_password, $is_admin);

        if ($stmt->execute()) {
            echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error al registrar el usuario. Inténtalo de nuevo.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Las contraseñas no coinciden. Inténtalo de nuevo.');</script>";
    }
}
?>