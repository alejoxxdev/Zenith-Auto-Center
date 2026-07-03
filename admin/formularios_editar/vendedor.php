<?php
if (isset($_GET['codigo_vendedor'])) {
    $codigo_vendedor = $_GET['codigo_vendedor'];
    $sql = "SELECT * FROM vendedor WHERE codigo_vendedor = '$codigo_vendedor'";
    $resultado = $conexion->query($sql);
    $vendedor = $resultado->fetch_assoc();
}
?>
<h2>Editar Vendedor</h2>
<form action="formulario.php?tabla=vendedor&t_formulario=formularios_editar" method="post">
    <input type="hidden" name="tabla" value="vendedor">
    <input type="hidden" name="accion" value="editar">
    <input type="hidden" name="o_codigo_vendedor" value="<?php echo $vendedor['codigo_vendedor']; ?>">

    <div class="form-group">
        <label for="codigo_vendedor">Código vendedor:</label>
        <input class="form-control" type="text" id="codigo_vendedor" name="codigo_vendedor" 
               pattern="[0-9]+" value="<?php echo htmlspecialchars($vendedor['codigo_vendedor']); ?>" required>
    </div>

    <div class="form-group">
        <label for="nombre_vendedor">Nombre del vendedor:</label>
        <input class="form-control" type="text" id="nombre_vendedor" name="nombre_vendedor" 
               value="<?php echo htmlspecialchars($vendedor['nombre_vendedor']); ?>" required>
    </div>

    <div class="form-group">
        <label for="telefono_vendedor">Teléfono:</label>
        <input class="form-control" type="number" id="telefono_vendedor" name="telefono_vendedor" 
               pattern="[0-9]{9}" value="<?php echo htmlspecialchars($vendedor['telefono_vendedor']); ?>" required>
    </div>

    <div class="form-group">
        <button class="btn" type="submit">Editar Vendedor</button>
    </div>
</form>

<?php
$accion = $_POST['accion'] ?? '';
if ($accion === 'editar') {
    $o_codigo_vendedor = $_POST['o_codigo_vendedor'];
    $codigo_vendedor = $_POST['codigo_vendedor'];
    $nombre_vendedor = $_POST['nombre_vendedor'];
    $telefono_vendedor = $_POST['telefono_vendedor'];

    if ($codigo_vendedor !== $o_codigo_vendedor) {
        if ($conexion->query("SELECT * FROM vendedor WHERE codigo_vendedor = '$codigo_vendedor'")->num_rows > 0) {
            echo "<script>alert('El código del vendedor ya existe.'); window.location.href = 'formulario.php?tabla=vendedor&t_formulario=formularios_editar&codigo_vendedor=$o_codigo_vendedor';</script>";
            exit;
        }
    }

    $sql = "UPDATE vendedor SET 
            codigo_vendedor = '$codigo_vendedor', 
            nombre_vendedor = '$nombre_vendedor', 
            telefono_vendedor = '$telefono_vendedor' 
            WHERE codigo_vendedor = '$o_codigo_vendedor'";

    if ($conexion->query($sql) === TRUE) {
        echo "<script>alert('Vendedor actualizado correctamente.'); window.location.href = 'formulario.php?tabla=vendedor';</script>";
    } else {
        echo "<script>alert('Error al actualizar el vendedor: " . addslashes($conexion->error) . "');</script>";
    }
}
?>
