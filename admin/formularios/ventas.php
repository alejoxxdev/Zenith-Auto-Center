
    <h2>Venta</h2>

    <form action="formulario.php?tabla=ventas" method="post">
        <input type="hidden" name="tabla" value="ventas">
        <input type="hidden" name="accion" value="crear">

        <div class="form-group">
            <label for="id_factura1">factura:</label>
            <select name="id_factura1" id="id_factura1" class="form-control">
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
            <label for="monto-final">Monto final:</label>
            <input class="form-control" type="number" id="monto-final" name="monto-final" placeholder="Ingresa monto final" required>
        </div>

        <div class="form-group">
            <label for="id_cliente1">Cliente</label>
            <select name="id_cliente1" id="id_cliente1" class="form-control">
                <option value="">Selecciona un cliente</option>
                <?php
                $query = "SELECT * FROM cliente";
                $resultado = $conexion->query($query);
                while ($cliente = $resultado->fetch_assoc()):
                ?>
                    <option value="<?php echo $cliente['id_cliente']; ?>"><?php echo $cliente['nombre_cliente']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>


        <div class="form-group">
            <button class="btn" type="submit">Agregar venta</button>
        </div>
    </form>

    <form action="formulario.php" method="get">
        <div class="form-group">
            <input type="hidden" name="tabla" value="ventas">
            <label for="buscar">Buscar venta:</label>
            <input class="form-control" type="text" name="buscar" placeholder="Buscar venta">
            <button class="btn" type="submit">Buscar</button>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>ID Factura</th>
                <th>Cliente</th>
                <th>Monto Final</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
            $query = "SELECT * FROM venta WHERE id_venta LIKE '%$buscar%' OR id_factura1 LIKE '%$buscar%' OR id_cliente1 LIKE '%$buscar%' OR monto_final LIKE '%$buscar%'";
            $resultado = $conexion->query($query);
            while ($venta = $resultado->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $venta['id_venta']; ?></td>
                    <td><?php echo $venta['id_factura1']; ?></td>
                    <td><?php echo $conexion->query("SELECT nombre_cliente FROM cliente WHERE id_cliente = " . $venta['id_cliente1'])->fetch_assoc()['nombre_cliente']; ?></td>
                    <td><?php echo $venta['monto_final']; ?></td>
                    <td class="acciones">
                        <div class="botones-contenedor">
                            <form action="formulario.php" method="get" style="display: inline;">
                                <input type="hidden" name="id_venta" value="<?php echo $venta['id_venta']; ?>">
                                <input type="hidden" name="tabla" value="ventas">
                                <input type="hidden" name="t_formulario" value="formularios_editar">
                                <button type="submit" class="btn btn-editar">Editar</button>
                            </form>
                            <form action="formulario.php?tabla=ventas" method="post" style="display: inline;">
                                <input type="hidden" name="id_venta" value="<?php echo $venta['id_venta']; ?>">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="tabla" value="ventas">
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
        $id_factura1 = $_POST['id_factura1'];
        $id_cliente1 = $_POST['id_cliente1'];
        $monto_final = $_POST['monto-final'];
        $query = "INSERT INTO venta (id_factura1, id_cliente1, monto_final) VALUES ('$id_factura1', '$id_cliente1', '$monto_final')";
        $conexion->query($query);
        if ($conexion->error) {
            echo "<p>Error al agregar la venta: " . $conexion->error . "</p>";
        } else {
            echo "<script>alert('Venta agregada exitosamente.'); window.location.href = 'formulario.php?tabla=ventas';</script>";
        }
    } elseif ($accion == 'eliminar') {
        $id_venta = $_POST['id_venta'];
        $query = "DELETE FROM venta WHERE id_venta = '$id_venta'";
        $conexion->query($query);
        if ($conexion->error) {
            echo "<p>Error al eliminar la venta: " . $conexion->error . "</p>";
        } else {
            echo "<script>alert('Venta eliminada exitosamente.'); window.location.href = 'formulario.php?tabla=ventas';</script>";
        }
    }
    ?>
