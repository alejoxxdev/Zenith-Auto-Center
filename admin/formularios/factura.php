 <h2>Factura</h2>
            <form action="formulario.php?tabla=factura" method="post">
                <input type="hidden" name="tabla" value="factura" class="form-group">
                <input type="hidden" name="accion" value="crear">

                <div class="form-group">
                    <label for="id_vehiculo">Fecha:</label>
                    <input class="form-control" type="date" id="fecha" name="fecha" placeholder="Ingresa la fecha" required>
                </div>

                <div class="form-group">
                    <label for="total">Total:</label>
                    <input class="form-control" type="number" id="total" name="total" placeholder="Ingresa el total" required>
                </div>

                <div class="form-group">
                    <button class="btn" type="submit">Agregar factura</button>
                </div>

                
            </form>


            <form action="formulario.php" method="get">
                <div class="form-group">
                    <input type="hidden" name="tabla" value="factura">
                    <label for="buscar">Buscar factura:</label>
                    <input class="form-control" type="text" name="buscar" placeholder="Buscar vehículo en factura">
                    <button class="btn" type="submit">Buscar</button>
                </div>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
                    $query = "SELECT * FROM factura WHERE fecha_factura LIKE '%$buscar%' OR total LIKE '%$buscar%'";
                    $resultado = $conexion->query($query);
                    while ($factura = $resultado->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?php echo $factura['id_factura']; ?></td>
                            <td><?php echo $factura['fecha_factura']; ?></td>
                            <td><?php echo $factura['total']; ?></td>
                            <td class="acciones">
                                <div class="botones-contenedor">
                                    <form action="formulario.php" method="get" style="display: inline;">
                                        <input type="hidden" name="tabla" value="factura">
                                        <input type="hidden" name="id_factura" value="<?php echo $factura['id_factura']; ?>">
                                        <input type="hidden" name="t_formulario" value="formularios_editar">
                                        <button type="submit" class="btn-editar btn">Editar</button>
                                    </form>
                                    <form action="formulario.php?tabla=factura" method="post" style="display: inline;">
                                        <input type="hidden" name="id_factura" value="<?php echo $factura['id_factura']; ?>">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="tabla" value="factura">
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
$accion = $_POST['accion'] ?? '';
if ($accion === 'crear') {
    $sql = "INSERT INTO factura (fecha_factura, total) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $_POST['fecha'], $_POST['total']);
    if ($stmt->execute()) {
        echo "<script>alert('Factura agregada exitosamente.'); window.location.href = 'formulario.php?tabla=factura';</script>";
    } else {
        echo "<script>alert('Error al agregar la factura: " . $stmt->error . "'); window.location.href = 'formulario.php?tabla=factura';</script>";
    }
}

else if ($accion === 'eliminar') {
    $id_factura = $_POST['id_factura'];
    $query = "DELETE FROM factura WHERE id_factura = $id_factura";
    try {
        $conexion->query($query);
    } catch (Exception $e) {
        if ($e->getCode() == 1451) {
            echo "<script>alert('No se puede eliminar la factura porque está asociada a otros registros.'); window.location.href = 'formulario.php?tabla=factura';</script>";
        }
        exit;
    }
    echo "<script>alert('Factura eliminada exitosamente.'); window.location.href = 'formulario.php?tabla=factura';</script>";
}


?>