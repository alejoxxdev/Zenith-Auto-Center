<h2>Vehiculo</h2>

<form class="form-group" action="formulario.php?tabla=vehiculo" enctype="multipart/form-data" method="post">
    <input type="hidden" name="tabla" value="vehiculos">
    <input type="hidden" name="accion" value="crear">

    <div class="form-group">
        <label for="placa_vehiculo">Placa:</label>
        <input class="form-control" type="text" id="placa_vehiculo" name="placa_vehiculo" placeholder="Ingresa la placa del vehiculo " required>
    </div>

    <div class="form-group">
        <label for="marca">Marca:</label>
        <input class="form-control" type="text" id="marca" name="marca" placeholder="Ingresa la marca del vehiculo " required>
    </div>

    <div class="form-group">
        <label for="nombre_vehiculo">Nombre:</label>
        <input class="form-control" type="text" id="nombre_vehiculo" name="nombre_vehiculo" placeholder="Ingresa el nombre del vehiculo " required>
    </div>

    <div class="form-group">
        <label for="modelo">Modelo:</label>
        <input class="form-control" type="text" id="modelo" name="modelo" placeholder="Ingresa el modelo del vehiculo " required>
    </div>

    <div class="form-group">
        <label for="color">Color:</label>
        <input class="form-control" type="text" id="color" name="color" placeholder="Ingresa el color del vehiculo " required>
    </div>



    <div class="categoria">
        <label for="categoria">Categoria:</label>
        <select name="categoria" id="categoria">
            <option value="carro">carro</option>
            <option value="moto">moto</option>
            <option value="camioneta">camioneta</option>
        </select>
    </div>

    <div class="form-group">
        <label for="detalles_vehiculo">Detalles del vehiculo:</label>
        <textarea name="detalles_vehiculo" id="detalles_vehiculo" placeholder="Ingresa los detalles del vehiculo" required></textarea>
    </div>

    <div class="form-group">
        <label for="imagen_vehiculo">Imagen del vehiculo:</label>
        <input class="form-control" type="file" id="imagen_producto" name="img" accept="image/*" required>
    </div>

    <div class="form-group">
        <label for="precio_venta_vehiculo">Precio de venta:</label>
        <input class="form-control" type="number" id="precio_venta_vehiculo" name="precio_venta_vehiculo" placeholder="Ingresa el precio del vehiculo " required>
    </div>

    <div class="form-group">
            <label for="codigo_vendedor2">Codigo vendedor:</label>
            <select name="codigo_vendedor2" id="codigo_vendedor2" class="form-control" required>
                <option value="" disabled selected>Selecciona un vendedor</option>
                <?php
                $query = "SELECT codigo_vendedor, nombre_vendedor FROM vendedor";
                $resultado = $conexion->query($query);
                while ($vendedor = $resultado->fetch_assoc()):
                ?>
                    <option value="<?php echo $vendedor['codigo_vendedor']; ?>">
                        <?php echo $vendedor['nombre_vendedor']; ?> (<?php echo $vendedor['codigo_vendedor']; ?>)
                    </option>
                <?php endwhile; ?>
            </select>
    </div>

    <div class="form-group">
        <label for="rut_proveedor1">RUT proveedor:</label>
        <select name="rut_proveedor1" id="rut_proveedor1" class="form-control" required>
            <option value="" disabled selected>Selecciona un proveedor</option>
            <?php
            $query = "SELECT RUT_proveedor, nombre_proveedor FROM proveedor";
            $resultado = $conexion->query($query);
            while ($proveedor = $resultado->fetch_assoc()):
            ?>
                <option value="<?php echo $proveedor['RUT_proveedor']; ?>">
                    <?php echo $proveedor['nombre_proveedor']; ?> (<?php echo $proveedor['RUT_proveedor']; ?>)
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div>
        <button class="btn" type="submit">Agregar vehiculo</button>
    </div>

</form>



<div class="form-group">
    <form action="formulario.php" method="get">
        <input type="hidden" name="tabla" value="vehiculo">
        <label for="buscar">Buscar vehiculo:</label>
        <input type="text" name="buscar" placeholder="Buscar vehiculo">
        <button class="btn" type="submit">Buscar</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Placa</th>
            <th>Marca</th>
            <th>Nombre</th>
            <th>Modelo</th>
            <th>Color</th>
            <th>Categoria</th>
            <th>Detalles</th>
            <th>Imagen</th>
            <th>Precio</th>
            <th>Vendedor</th>
            <th>Proveedor</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
        $query = "SELECT * FROM vehiculo  WHERE id_vehiculo  LIKE '%$buscar%' OR placa_vehiculo LIKE '%$buscar%' OR marca LIKE '%$buscar%' OR nombre_vehiculo LIKE '%$buscar%' OR modelo LIKE '%$buscar%' OR color LIKE '%$buscar%' OR detalles_vehiculo LIKE '%$buscar%' OR imagen LIKE '%$buscar%' OR precio_venta_vehiculo LIKE '%$buscar%' OR codigo_vendedor1 LIKE '%$buscar%' OR RUT_proveedor1 LIKE '%$buscar%' OR categoria LIKE '%$buscar%'";
        $resultado = $conexion->query($query);
        while ($vehiculo = $resultado->fetch_assoc()):
        ?>
        <tr>
            <td><?php echo $vehiculo['id_vehiculo']; ?></td>
            <td><?php echo $vehiculo['placa_vehiculo']; ?></td>
            <td><?php echo $vehiculo['marca']; ?></td>
            <td><?php echo $vehiculo['nombre_vehiculo']; ?></td>
            <td><?php echo $vehiculo['modelo']; ?></td>
            <td><?php echo $vehiculo['color']; ?></td>
            <td><?php echo $vehiculo['categoria']; ?></td>
            <td><?php echo $vehiculo['detalles_vehiculo']; ?></td>
            <td><img src=".<?php echo $vehiculo['imagen']; ?>" alt="<?php echo $vehiculo['nombre_vehiculo']; ?>" width="120"></td>
            <td><?php echo $vehiculo['precio_venta_vehiculo']; ?></td>
            <td><?php echo $conexion->query("SELECT nombre_vendedor FROM vendedor WHERE codigo_vendedor = " . $vehiculo['codigo_vendedor1'])->fetch_assoc()['nombre_vendedor']; ?></td>
            <td><?php echo $conexion->query("SELECT nombre_proveedor FROM proveedor WHERE RUT_proveedor = " . $vehiculo['rut_proveedor1'])->fetch_assoc()['nombre_proveedor']; ?></td>
            <td class="acciones">
                <div class="form-group">
                    <form class="form-container" action="formulario.php" method="get" style="display: inline;">
                        <input class="form-control" type="hidden" name="id_vehiculo" value="<?php echo $vehiculo['id_vehiculo']; ?>">
                        <input class="form-control" type="hidden" name="tabla" value="vehiculo">
                        <input class="form-control" type="hidden" name="t_formulario" value="formularios_editar">
                        <button class="btn" type="submit" class="btn-editar">Editar</button>
                    </form>
                    <form action="formulario.php?tabla=vehiculo" method="post" style="display: inline;">
                        <input class="form-control" type="hidden" name="id_vehiculo" value="<?php echo $vehiculo['id_vehiculo']; ?>">
                        <input class="form-control" type="hidden" name="accion" value="eliminar">
                        <button class="btn" type="submit" class="btn-eliminar">Eliminar</button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$accion = $_POST['accion'] ?? '';
if ($accion == 'crear') {
    $placa_vehiculo = $_POST['placa_vehiculo'];
    $marca = $_POST['marca'];
    $nombre_vehiculo = $_POST['nombre_vehiculo'];
    $modelo = $_POST['modelo'];
    $color = $_POST['color'];
    $categoria = $_POST['categoria'];
    $detalles_vehiculo = $_POST['detalles_vehiculo'];
    $precio_venta_vehiculo = $_POST['precio_venta_vehiculo'];
    $codigo_vendedor2 = $_POST['codigo_vendedor2'];
    $rut_proveedor1 = $_POST['rut_proveedor1'];
    
    // Manejo de la imagen
    $imagen = $_FILES['img'];
    $nombre_imagen = $imagen['name'];
    $ruta_temporal = $imagen['tmp_name'];
    $ruta_destino = "../img/vehiculos/" ."$categoria". "s/" . time() . "_" . $nombre_imagen;
    move_uploaded_file($ruta_temporal, $ruta_destino);
    $imagen_db = "./img/vehiculos/" ."$categoria". "s/" . time() . "_" . $nombre_imagen;
    $query = "INSERT INTO vehiculo (placa_vehiculo, marca, nombre_vehiculo, modelo, color, categoria, detalles_vehiculo, imagen, precio_venta_vehiculo, codigo_vendedor1, RUT_proveedor1) VALUES ('$placa_vehiculo', '$marca', '$nombre_vehiculo', '$modelo', '$color', '$categoria', '$detalles_vehiculo', '$imagen_db', '$precio_venta_vehiculo', '$codigo_vendedor2', '$rut_proveedor1')";
    if ($conexion->query($query)) {
        echo "<script>alert('Vehiculo agregado exitosamente.'); window.location.href = 'formulario.php?tabla=vehiculo';</script>";
    } else {
        echo "<p>Error al agregar el vehiculo: " . $conexion->error . "</p>";
    }
}
else if ($accion == 'eliminar') {
    $id_vehiculo = $_POST['id_vehiculo'];
    $query = "DELETE FROM vehiculo WHERE id_vehiculo = '$id_vehiculo'";
    try {
        $conexion->query($query);
    } catch (Exception $e) {
        if ($e->getCode() == 1451) {
            echo "<script>alert('No se puede eliminar el vehiculo porque está asociado a otros registros.'); window.location.href = 'formulario.php?tabla=vehiculo';</script>";
        }
        exit;
    }
    echo "<script>alert('Vehiculo eliminado exitosamente.'); window.location.href = 'formulario.php?tabla=vehiculo';</script>";
}
?>