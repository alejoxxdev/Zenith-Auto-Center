<?php
if (isset($_GET['id_vehiculo'])) {
    $id_vehiculo = $_GET['id_vehiculo'];
    $sql = "SELECT * FROM vehiculo WHERE id_vehiculo = '$id_vehiculo'";
    $resultado = $conexion->query($sql);
    $vehiculo = $resultado->fetch_assoc();
}
?>
<h2>Editar Vehículo</h2>
<form action="formulario.php?tabla=vehiculo&t_formulario=formularios_editar" method="post" enctype="multipart/form-data">
    <input type="hidden" name="tabla" value="vehiculo">
    <input type="hidden" name="accion" value="editar">
    <input type="hidden" name="id_vehiculo" value="<?php echo $vehiculo['id_vehiculo']; ?>">

    <div class="form-group">
        <label for="placa_vehiculo">Placa:</label>
        <input class="form-control" type="text" id="placa_vehiculo" name="placa_vehiculo" 
               value="<?php echo htmlspecialchars($vehiculo['placa_vehiculo']); ?>">
    </div>

    <div class="form-group">
        <label for="marca">Marca:</label>
        <input class="form-control" type="text" id="marca" name="marca" 
               value="<?php echo htmlspecialchars($vehiculo['marca']); ?>" required>
    </div>

    <div class="form-group">
        <label for="nombre_vehiculo">Nombre:</label>
        <input class="form-control" type="text" id="nombre_vehiculo" name="nombre_vehiculo" 
               value="<?php echo htmlspecialchars($vehiculo['nombre_vehiculo']); ?>" required>
    </div>

    <div class="form-group">
        <label for="modelo">Modelo:</label>
        <input class="form-control" type="text" id="modelo" name="modelo" 
               value="<?php echo htmlspecialchars($vehiculo['modelo']); ?>" required>
    </div>

    <div class="form-group">
        <label for="color">Color:</label>
        <input class="form-control" type="text" id="color" name="color" 
               value="<?php echo htmlspecialchars($vehiculo['color']); ?>" required>
    </div>

    <div class="form-group">
        <label for="categoria">Categoría:</label>
        <select name="categoria" id="categoria" class="form-control" required>
            <option value="carro" <?php echo ($vehiculo['categoria'] == 'carro') ? 'selected' : ''; ?>>Carro</option>
            <option value="moto" <?php echo ($vehiculo['categoria'] == 'moto') ? 'selected' : ''; ?>>Moto</option>
            <option value="camioneta" <?php echo ($vehiculo['categoria'] == 'camioneta') ? 'selected' : ''; ?>>Camioneta</option>
        </select>
    </div>

    <div class="form-group">
        <label for="detalles_vehiculo">Detalles del vehículo:</label>
        <textarea name="detalles_vehiculo" id="detalles_vehiculo" class="form-control" required><?php echo htmlspecialchars($vehiculo['detalles_vehiculo']); ?></textarea>
    </div>

    <div class="form-group">
        <label for="imagen">Imagen del vehículo:</label>
        <input class="form-control" type="file" id="imagen" name="imagen" accept="image/*">
        <small>Ruta actual: <?php echo $vehiculo['imagen']; ?></small>
    </div>

    <div class="form-group">
        <label for="precio_venta_vehiculo">Precio de venta:</label>
        <input class="form-control" type="number" step="0.01" id="precio_venta_vehiculo" name="precio_venta_vehiculo" 
               value="<?php echo $vehiculo['precio_venta_vehiculo']; ?>" required>
    </div>

    <div class="form-group">
        <label for="codigo_vendedor1">Vendedor:</label>
        <select name="codigo_vendedor1" id="codigo_vendedor1" class="form-control" required>
            <option value="">Selecciona un vendedor</option>
            <?php
            $query = "SELECT codigo_vendedor, nombre_vendedor FROM vendedor";
            $resultado_vendedores = $conexion->query($query);
            while ($vend = $resultado_vendedores->fetch_assoc()):
            ?>
                <option value="<?php echo $vend['codigo_vendedor']; ?>" 
                    <?php echo ($vend['codigo_vendedor'] == $vehiculo['codigo_vendedor1']) ? 'selected' : ''; ?>>
                    <?php echo $vend['nombre_vendedor']; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="rut_proveedor1">RUT Proveedor:</label>
        <select name="rut_proveedor1" id="rut_proveedor1" class="form-control" required>
            <option value="">Selecciona un proveedor</option>
            <?php
            $query = "SELECT RUT_proveedor, nombre_proveedor FROM proveedor";
            $resultado_proveedores = $conexion->query($query);
            while ($prov = $resultado_proveedores->fetch_assoc()):
            ?>
                <option value="<?php echo $prov['RUT_proveedor']; ?>" 
                    <?php echo ($prov['RUT_proveedor'] == $vehiculo['rut_proveedor1']) ? 'selected' : ''; ?>>
                    <?php echo $prov['nombre_proveedor']; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <button class="btn" type="submit">Editar Vehículo</button>
    </div>
</form>

<?php
$accion = $_POST['accion'] ?? '';
if ($accion === 'editar') {
    $id_vehiculo = $_POST['id_vehiculo'];
    $marca = $_POST['marca'];
    $nombre_vehiculo = $_POST['nombre_vehiculo'];
    $modelo = $_POST['modelo'];
    $color = $_POST['color'];
    $categoria = $_POST['categoria'];
    $detalles_vehiculo = $_POST['detalles_vehiculo'];
    $precio_venta_vehiculo = $_POST['precio_venta_vehiculo'];
    $codigo_vendedor1 = $_POST['codigo_vendedor1'];
    $rut_proveedor1 = $_POST['rut_proveedor1'];
    $placa_vehiculo = $_POST['placa_vehiculo'] ?? '';

    $imagen = $vehiculo['imagen'];
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $nombre_archivo = basename($_FILES['imagen']['name']);
        $ruta = '/img/vehiculos/' . $categoria . 's/' . time() . '_' . $nombre_archivo;
        move_uploaded_file($_FILES['imagen']['tmp_name'], '.' . $ruta);
        $imagen = $ruta;
    }

    $sql = "UPDATE vehiculo SET 
            marca = '$marca', 
            nombre_vehiculo = '$nombre_vehiculo', 
            modelo = '$modelo', 
            color = '$color', 
            categoria = '$categoria', 
            detalles_vehiculo = '$detalles_vehiculo', 
            imagen = '$imagen', 
            precio_venta_vehiculo = '$precio_venta_vehiculo', 
            codigo_vendedor1 = '$codigo_vendedor1', 
            rut_proveedor1 = '$rut_proveedor1',
            placa_vehiculo = '$placa_vehiculo'
            WHERE id_vehiculo = '$id_vehiculo'";

    if ($conexion->query($sql) === TRUE) {
        echo "<script>alert('Vehículo actualizado correctamente.'); window.location.href = 'formulario.php?tabla=vehiculo';</script>";
    } else {
        echo "<script>alert('Error al actualizar el vehículo: " . addslashes($conexion->error) . "');</script>";
    }
}
?>