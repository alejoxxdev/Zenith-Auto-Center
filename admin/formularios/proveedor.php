            <h2>Proveedor</h2>

            <form action="formulario.php?tabla=proveedor" method="post">
                <input type="hidden" name="tabla" value="proveedor" class="form-group">
                <input type="hidden" name="accion" value="crear">

                <div class="form-group">
                    <label for="RUT_proveedor">RUT proveedor:</label>
                    <input class="form-control" type="text" pattern="[0-9]+" id="RUT_proveedor" name="RUT_proveedor" placeholder="Ingresa el RUT proveedor" required>
                </div>

                <div class="form-group">
                    <label for="nombre_proveedor">Nombre:</label>
                    <input class="form-control" type="text" id="nombre_proveedor" name="nombre_proveedor" placeholder="Ingresa el nombre" required>
                </div>


                <div class="form-group">
                    <label for="direccion_proveedor">Dirección:</label>
                    <input class="form-control" type="text" id="direccion_proveedor" name="direccion_proveedor" placeholder="Ingresa la dirección" required>
                </div>

                <div class="form-group">
                    <label for="telefono_proveedor">Telefono:</label>
                    <input class="form-control" type="text" pattern="[0-9]+" id="telefono_proveedor" name="telefono_proveedor" placeholder="Ingresa el telefono" required>

                </div>

                <div class="form-group">
                    <label for="email_proveedor">Email:</label>
                    <input class="form-control" type="email" id="email_proveedor" name="email_proveedor" placeholder="Ingresa el email" required>
                </div>

                <div class="form-group">
                    <label for="redes_sociales_proveedor">Redes sociales:</label>
                    <input class="form-control" type="text" id="redes_sociales_proveedor" name="redes_sociales_proveedor" placeholder="Ingresa las redes sociales" required>
                    <button class="btn" type="submit">Agregar Proveedor</button>
                </div>

            </form>


            <form action="formulario.php" method="get">
                <div class="form-group">
                    <input type="hidden" name="tabla" value="proveedor">
                    <label for="buscar">Buscar proveedor:</label>
                    <input class="form-control" type="text" name="buscar" placeholder="Buscar proveedor">
                    <button class="btn" type="submit">Buscar</button>
                </div>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>RUT </th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Redes sociales</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
                    $query = "SELECT * FROM proveedor WHERE RUT_proveedor LIKE '%$buscar%' OR nombre_proveedor LIKE '%$buscar%' OR direccion_proveedor LIKE '%$buscar%' OR telefono_proveedor LIKE '%$buscar%'  OR email_proveedor LIKE '%$buscar%' OR RedesSociales_proveedor LIKE '%$buscar%' ";
                    $resultado = $conexion->query($query);
                    while ($proveedor = $resultado->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?php echo $proveedor['RUT_proveedor']; ?></td>
                            <td><?php echo $proveedor['nombre_proveedor']; ?></td>
                            <td><?php echo $proveedor['direccion_proveedor']; ?></td>
                            <td><?php echo $proveedor['telefono_proveedor']; ?></td>
                            <td><?php echo $proveedor['email_proveedor']; ?></td>
                            <td><?php echo $proveedor['RedesSociales_proveedor']; ?></td>
                            <td class="acciones">
                                <div class="botones-contenedor">
                                    <form action="formulario.php" method="get" style="display: inline;">
                                        <input type="hidden" name="RUT_proveedor" value="<?php echo $proveedor['RUT_proveedor']; ?>">
                                        <input type="hidden" name="tabla" value="proveedor">
                                        <input type="hidden" name="t_formulario" value="formularios_editar">
                                        <button type="submit" class="btn-editar btn">Editar</button>
                                    </form>
                                    <form action="formulario.php?tabla=proveedor" method="post" style="display: inline;">
                                        <input type="hidden" name="RUT_proveedor" value="<?php echo $proveedor['RUT_proveedor']; ?>">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="tabla" value="proveedores">
                                        <div class="form-group">
                                            <button class="btn" type="submit" class="btn-eliminar">Eliminar</button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

<?php
$accion = isset($_POST['accion']) ? $_POST['accion'] : '';
if ($accion == 'crear') {
    $RUT_proveedor = $_POST['RUT_proveedor'];
    $nombre_proveedor = $_POST['nombre_proveedor'];
    $direccion_proveedor = $_POST['direccion_proveedor'];
    $telefono_proveedor = $_POST['telefono_proveedor'];
    $email_proveedor = $_POST['email_proveedor'];
    $RedesSociales_proveedor = $_POST['redes_sociales_proveedor'];
    if ($conexion->query("SELECT * FROM proveedor WHERE RUT_proveedor = '$RUT_proveedor'")->num_rows > 0) {
        echo "<script>alert('Error: Ya existe un proveedor con el RUT '$RUT_proveedor'.');</script>";
        exit;
    }
    $query = "INSERT INTO proveedor (RUT_proveedor, nombre_proveedor, direccion_proveedor, telefono_proveedor, email_proveedor, RedesSociales_proveedor) VALUES ('$RUT_proveedor', '$nombre_proveedor', '$direccion_proveedor', '$telefono_proveedor', '$email_proveedor', '$RedesSociales_proveedor')";
    $conexion->query($query);
    if ($conexion->error) {
        echo "<p>Error al agregar el proveedor: " . $conexion->error . "</p>";
    } else {
        echo "<script>alert('Proveedor agregado exitosamente.'); window.location.href = 'proveedor.php?tabla=proveedor';</script>";
    }

}
else if ($accion == 'eliminar') {
    $RUT_proveedor = $_POST['RUT_proveedor'];
    $query = "DELETE FROM proveedor WHERE RUT_proveedor = '$RUT_proveedor'";
    try {
        $conexion->query($query);
        
    } catch (Exception $e) {
        if ($e->getCode() == 1451) {
            echo "<script>alert('No se puede eliminar el proveedor porque está asociado a otros registros.'); window.location.href = 'formulario.php?tabla=proveedor';</script>";
            exit;
        }
    }
    echo "<script>alert('Proveedor eliminado exitosamente.'); window.location.href = 'formulario.php?tabla=proveedor';</script>";
}
    

?>