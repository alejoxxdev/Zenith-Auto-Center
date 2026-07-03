<?php
if (isset($_GET['id_sugerencia'])) {
$id_sugerencia = $_GET['id_sugerencia'];
$sql = "SELECT * FROM sugerencia WHERE id_sugerencia = $id_sugerencia";
$resultado = $conexion->query($sql);
$sugerencia = $resultado->fetch_assoc();
}
?>
<h2>Sugerencia</h2>

    <form action="formulario.php?tabla=sugerencia&t_formulario=formularios_editar" method="post">
        <input type="hidden" name="tabla" value="sugerencia">
        <input type="hidden" name="accion" value="editar">

        <input type="hidden" name="id_sugerencia" value="<?php echo $sugerencia['id_sugerencia']; ?>">

        <div class="form-group">
            <label for="nombre">Nombres y apellidos:</label>
            <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Ingresa tus nombres" required value="<?php echo $sugerencia['nombre']; ?>">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input class="form-control" type="email" id="email" name="email" placeholder="Ingresa el email" required value="<?php echo $sugerencia['correo']; ?>">
        </div>

        <div class="form-group">
            <label for="asunto">Asunto:</label>
            <input class="form-control" type="text" id="asunto" name="asunto" placeholder="Ingresa el asunto" required value="<?php echo $sugerencia['asunto']; ?>">
        </div>

        <div class="form-group">
            <label for="mensaje">Mensaje:</label>
            <textarea class="form-control" id="mensaje" name="mensaje" rows="4" placeholder="Ingresa tu mensaje" required><?php echo $sugerencia['mensaje']; ?></textarea>
        </div>

        

        <div class="form-group">
            <button class="btn" type="submit">Editar Sugerencia</button>
        </div>
    </form>

<?php
$accion = $_POST['accion'] ?? '';
if ($accion === 'editar') {
    $id_sugerencia = $_POST['id_sugerencia'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['email'];
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];

    $sql = "UPDATE sugerencia SET nombre='$nombre', correo='$correo', asunto='$asunto', mensaje='$mensaje' WHERE id_sugerencia=$id_sugerencia";
    if ($conexion->query($sql) === TRUE) {
        echo "<script>alert('Sugerencia editada exitosamente.'); window.location.href = 'formulario.php?tabla=sugerencia';</script>";
    } else {
        echo "<p>Error al editar la sugerencia: " . $conexion->error . "</p>";
    }
}

?>