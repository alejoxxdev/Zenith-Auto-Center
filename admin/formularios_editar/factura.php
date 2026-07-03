<?php
if (isset($_GET['id_factura'])) {
    $id_factura = $_GET['id_factura'];
    $sql = "SELECT * FROM factura WHERE id_factura = $id_factura";
    $resultado = $conexion->query($sql);
    $factura = $resultado->fetch_assoc();
}
?>
<h2>Editar Factura</h2>
<form action="formulario.php?tabla=factura&t_formulario=formularios_editar" method="post">
    <input type="hidden" name="tabla" value="factura">
    <input type="hidden" name="accion" value="editar">
    <input type="hidden" name="id_factura" value="<?php echo $factura['id_factura']; ?>">

    <div class="form-group">
        <label for="fecha_factura">Fecha:</label>
        <input class="form-control" type="date" id="fecha_factura" name="fecha_factura" 
               value="<?php echo $factura['fecha_factura']; ?>" required>
    </div>

    <div class="form-group">
        <label for="total">Total:</label>
        <input class="form-control" type="number" step="0.01" id="total" name="total" 
               value="<?php echo $factura['total']; ?>" required>
    </div>

    <div class="form-group">
        <button class="btn" type="submit">Editar Factura</button>
    </div>
</form>

<?php
$accion = $_POST['accion'] ?? '';
if ($accion === 'editar') {
    $id_factura = $_POST['id_factura'];
    $fecha_factura = $_POST['fecha_factura'];
    $total = $_POST['total'];

    $sql = "UPDATE factura SET 
            fecha_factura = '$fecha_factura', 
            total = '$total' 
            WHERE id_factura = $id_factura";

    if ($conexion->query($sql) === TRUE) {
        echo "<script>alert('Factura actualizada correctamente.'); window.location.href = 'formulario.php?tabla=factura';</script>";
    } else {
        echo "<script>alert('Error al actualizar la factura: " . addslashes($conexion->error) . "');</script>";
    }
}
?>



