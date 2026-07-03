<?php

session_start();
include "conexion.php";

$error = "";
//Verificar si el usuario ya existe
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $usuario = $_POST["username"];
    $password = $_POST["password"];
    $confirmar_password = $_POST["confirmar_password"];

    //Validar que los datos ingresados no esten vacios
    if (empty($usuario) || empty($password) || empty($confirmar_password)) {
        $error = "Todos los campos son obligatorios.";
    }elseif ($password !== $confirmar_password) {
        //Verificar si las contraseñas enviadas son iguales
        echo '<script type "text/javascript"> alert("Las contraseñas no coinciden"); window.location.href="registrar.php";</script>';
    } else {
        //Validar si el usuario existe en la base de datos
        $consulta_sql = $conexion->prepare("SELECT * FROM login WHERE username = ?");
        $consulta_sql->execute([$usuario]);

        //Confirmar si se encontro un usuario con ese mismo nombre
        if ($consulta_sql->fetch()) {
            echo '<script type "text/javascript"> alert("El usuario ya existe, intenta con otro"); window.location.href="registrar.php";</script>';
        }else {
            //Si no existe el usuario se procede a registrar
            $consulta_sql = $conexion->prepare("INSERT INTO login (username, password) VALUES (?, ?)");
        
            if ($consulta_sql->execute([$usuario, $password])) {
                $_SESSION['username'] = $usuario;
                header("Location: login.php");
                exit();
            }else {
                echo '<script type "text/javascript"> alert("Error al registrar el usuario"); window.location.href="registrar.php";</script>';  
            }
        }
    }
}

?>