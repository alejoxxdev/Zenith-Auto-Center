<?php
if (isset($_GET['id_venta'])) {
    $id_venta = $_GET['id_venta'];
    $sql = "SELECT * FROM venta WHERE id_venta = $id_venta";
    $resultado = $conexion->query($sql);
    $venta = $resultado->fetch_assoc();
}
?>
<h2>Editar Venta</h2>
<form action="formulario.php?tabla=ventas&t_formulario=formularios_editar" method="post">
    <input type="hidden" name="tabla" value="ventas">
    <input type="hidden" name="accion" value="editar">
    <input type="hidden" name="id_venta" value="<?php echo $venta['id_venta']; ?>">

    <div class="form-group">
        <label for="id_factura1">Factura:</label>
        <select name="id_factura1" id="id_factura1" class="form-control" required>
            <option value="">Selecciona una factura</option>
            <?php
            $query = "SELECT id_factura FROM factura";
            $resultado_facturas = $conexion->query($query);
            while ($factura = $resultado_facturas->fetch_assoc()):
            ?>
                <option value="<?php echo $factura['id_factura']; ?>" 
                    <?php echo ($factura['id_factura'] == $venta['id_factura1']) ? 'selected' : ''; ?>>
                    <?php echo $factura['id_factura']; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="monto_final">Monto final:</label>
        <input class="form-control" type="number" step="0.01" id="monto_final" name="monto_final" 
               value="<?php echo $venta['monto_final']; ?>" required>
    </div>

    <div class="form-group">
        <label for="id_cliente1">Cliente:</label>
        <select name="id_cliente1" id="id_cliente1" class="form-control" required>
            <option value="">Selecciona un cliente</option>
            <?php
            $query = "SELECT id_cliente, nombre_cliente FROM cliente";
            $resultado_clientes = $conexion->query($query);
            while ($cliente = $resultado_clientes->fetch_assoc()):
            ?>
                <option value="<?php echo $cliente['id_cliente']; ?>" 
                    <?php echo ($cliente['id_cliente'] == $venta['id_cliente1']) ? 'selected' : ''; ?>>
                    <?php echo $cliente['nombre_cliente']; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <button class="btn" type="submit">Editar Venta</button>
    </div>
</form>

<?php
$accion = $_POST['accion'] ?? '';
if ($accion === 'editar') {
    $id_venta = $_POST['id_venta'];
    $id_factura1 = $_POST['id_factura1'];
    $monto_final = $_POST['monto_final'];
    $id_cliente1 = $_POST['id_cliente1'];

    $sql = "UPDATE venta SET 
            id_factura1 = '$id_factura1', 
            monto_final = '$monto_final', 
            id_cliente1 = '$id_cliente1' 
            WHERE id_venta = $id_venta";

    if ($conexion->query($sql) === TRUE) {
        echo "<script>alert('Venta actualizada correctamente.'); window.location.href = 'formulario.php?tabla=ventas';</script>";
    } else {
        echo "<script>alert('Error al actualizar la venta: " . addslashes($conexion->error) . "');</script>";
    }
}
