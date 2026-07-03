<?php
   if (isset($_GET['id_v_factura'])) {
         $id_v_factura = $_GET['id_v_factura'];
         $sql = "SELECT * FROM vehiculo_factura WHERE id_vehiculo_factura = $id_v_factura";
         $resultado = $conexion->query($sql);
         $v_factura = $resultado->fetch_assoc();
         $precio_unitario = $v_factura['precio_unitario'];
         $cantidad = $v_factura['cantidad'];
         $subtotal = $v_factura['subtotal'];
   }
?>

 <h2>Vehículo en Factura editar</h2>

            <form action="formulario.php?tabla=v_factura&t_formulario=formularios_editar" method="post">
                <input type="hidden" name="id_vehiculo_factura" value="<?php echo $id_v_factura; ?>" class="form-group">    
                <input type="hidden" name="tabla" value="vehiculo_factura" class="form-group">
                <input type="hidden" name="accion" value="editar">

                <div class="form-group">
                    <label for="id_factura1">Factura:</label>
                    <select name="id_factura1" id="id_factura1" class="form-control" required>
                        <option value="">Selecciona una factura</option>
                        <?php
                        $query = "SELECT * FROM factura";
                        $resultado = $conexion->query($query);
                        while ($factura = $resultado->fetch_assoc()):
                        ?>
                            <option value="<?php echo $factura['id_factura']; ?>"><?php echo $factura['id_factura']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_vehiculo1">Vehículo:</label>
                    <select name="id_vehiculo1" id="id_vehiculo1" class="form-control" required>
                        <option value="">Selecciona un vehículo</option>
                        <?php
                        $query = "SELECT * FROM vehiculo";
                        $resultado = $conexion->query($query);
                        while ($vehiculo = $resultado->fetch_assoc()):
                        ?>
                            <option value="<?php echo $vehiculo['id_vehiculo']; ?>"><?php echo $vehiculo['nombre_vehiculo']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="precio_unitario">Precio Unitario:</label>
                    <input class="form-control" type="number" id="precio_unitario" name="precio_unitario" placeholder="Ingresa el precio unitario" value="<?php echo $precio_unitario; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="cantidad">Cantidad:</label>
                    <input class="form-control" type="number" id="cantidad" name="cantidad" placeholder="Ingresa la cantidad" value="<?php echo $cantidad; ?>" required>
                </div>

                <div class="form-group">
                    <label for="subtotal">Subtotal:</label>
                    <input class="form-control" type="number" id="subtotal" name="subtotal" placeholder="Ingresa el subtotal" value="<?php echo $subtotal; ?>" required>
                </div>

                <div class="form-group">
                    <button class="btn" type="submit">Editar vehículo en factura</button>
                </div>
            </form>

<?php
$accion = isset($_POST['accion']) ? $_POST['accion'] : '';
if ($accion === 'editar') {
    $id_v_factura = $_POST['id_vehiculo_factura'];
    $id_factura1 = $_POST['id_factura1'];
    $id_vehiculo1 = $_POST['id_vehiculo1'];
    $precio_unitario = $_POST['precio_unitario'];
    $cantidad = $_POST['cantidad'];
    $subtotal = $_POST['subtotal'];

    $sql = "UPDATE vehiculo_factura SET 
            id_factura1 = '$id_factura1', 
            id_vehiculo1 = '$id_vehiculo1', 
            precio_unitario = '$precio_unitario', 
            cantidad = '$cantidad', 
            subtotal = '$subtotal' 
            WHERE id_vehiculo_factura = $id_v_factura";

    try {
        $conexion->query($sql);
        echo "<script>alert('Vehículo en factura actualizado correctamente'); window.location.href = 'formulario.php?tabla=v_factura';</script>";
    } catch (Exception $e) {
        if ($e->getCode() == 1451) {    
            echo "<script>alert('No se puede actualizar el vehículo en factura porque está asociado a otros registros.'); window.history.back();</script>";
            exit;
        }
    }
}
?>
</div>