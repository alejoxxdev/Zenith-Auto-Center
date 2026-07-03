<?php

$conexion = new mysqli("localhost", "root", "", "zenith_auto_center");
if ($conexion -> connect_error) {
    die ("Error de conexion: " . $conexion -> connect_error);
}
/*else {
    echo "Conexion exitosa a la base de datos";
}*/
?>
