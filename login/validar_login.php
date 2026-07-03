<?php

session_start();
include 'conexion.php';

$usuario = $_POST['username'];
$password = $_POST['password'];

//Se realiza la consulta a la base de datos y la tabla login
$consulta = "SELECT * FROM login WHERE username = '$usuario' AND password = '$password'";
$resultado = mysqli_query($conexion, $consulta);

//Verificamos si la consulta fue exitosa
$registros = mysqli_num_rows($resultado);

//Verificar si encontramos el ususarios y la contraseña
if ($registros > 0) {
    $_SESSION['username'] = $usuario && $_SESSION['password'] = $password;
    header('Location: login.php? mensaje = Bienvenido, $usuario');
} else {
    echo '<script type "text/javascript"> alert("Usuario o contraseña incorrecta"); window.location.href="login.php";</script>';
}

//Liberar el resultado y cerrar la conexion con la base de datos 
mysqli_free_result($resultado);

//Cerramos la conexion con la base de datos
mysqli_close($conexion);

?>