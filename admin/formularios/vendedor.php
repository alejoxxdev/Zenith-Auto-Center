
    <h2>Vendedor</h2>

    <form action="formulario.php?tabla=vendedor" method="post">
        <input type="hidden" name="tabla" value="vendedor">
        <input type="hidden" name="accion" value="crear">

        <div class="form-group">
            <label for="codigo_vendedor">Código vendedor:</label>
            <input class="form-control" type="text" id="codigo_vendedor" pattern="[0-9]+" name="codigo_vendedor" placeholder="Ingresa código de vendedor" required>
        </div>

        <div class="form-group">
            <label for="nombre_vendedor">Nombre del vendedor:</label>
            <input class="form-control" type="text" id="nombre_vendedor" name="nombre_vendedor" placeholder="Ingresa el nombre del vendedor" required>
        </div>

        <div class="form-group">
            <label for="telefono_vendedor">Teléfono:</label>
            <input class="form-control" type="number" id="telefono_vendedor" name="telefono_vendedor" pattern="[0-9]{9}" placeholder="Ingresa el teléfono del vendedor" required>
        </div>

        <div class="form-group">
            <button class="btn" type="submit">Agregar Vendedor</button>
        </div>
    </form>

    <form action="formulario.php" method="get">
        <div class="form-group">
            <input type="hidden" name="tabla" value="vendedor">
            <label for="buscar">Buscar vendedor:</label>
            <input class="form-control" type="text" name="buscar" placeholder="Buscar vendedor">
            <button class="btn" type="submit">Buscar</button>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
            $query = "SELECT * FROM vendedor WHERE codigo_vendedor LIKE '%$buscar%' OR nombre_vendedor LIKE '%$buscar%' OR telefono_vendedor LIKE '%$buscar%'";
            $resultado = $conexion->query($query);
            while ($vendedor = $resultado->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $vendedor['codigo_vendedor']; ?></td>
                    <td><?php echo $vendedor['nombre_vendedor']; ?></td>
                    <td><?php echo $vendedor['telefono_vendedor']; ?></td>
                    <td class="acciones">
                        <div class="botones-contenedor">
                            <form action="formulario.php" method="get" style="display: inline;">
                                <input type="hidden" name="codigo_vendedor" value="<?php echo $vendedor['codigo_vendedor']; ?>">
                                <input type="hidden" name="tabla" value="vendedor">
                                <input type="hidden" name="t_formulario" value="formularios_editar">
                                <button type="submit" class="btn-editar btn">Editar</button>
                            </form>
                            <form action="formulario.php?tabla=vendedor" method="post" style="display: inline;">
                                <input type="hidden" name="codigo_vendedor" value="<?php echo $vendedor['codigo_vendedor']; ?>">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="tabla" value="vendedor">
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
        $codigo_vendedor = $_POST['codigo_vendedor'];
        $nombre_vendedor = $_POST['nombre_vendedor'];
        $telefono_vendedor = $_POST['telefono_vendedor'];
        if ($conexion->query("SELECT * FROM vendedor WHERE codigo_vendedor = '$codigo_vendedor'")->num_rows > 0) {
            echo "<p>Error: Ya existe un vendedor con el código '$codigo_vendedor'.</p>";
            exit;
        }

        $query = "INSERT INTO vendedor (codigo_vendedor, nombre_vendedor, telefono_vendedor) VALUES ('$codigo_vendedor', '$nombre_vendedor', '$telefono_vendedor')";
        $conexion->query($query);
        if ($conexion->error) {
            echo "<p>Error al agregar el vendedor: " . $conexion->error . "</p>";
        } else {
            echo "<script>alert('Vendedor agregado exitosamente.'); window.location.href = 'formulario.php?tabla=vendedor';</script>";
        }
    } elseif ($accion == 'eliminar') {
        $codigo_vendedor = $_POST['codigo_vendedor'];
        $query = "DELETE FROM vendedor WHERE codigo_vendedor = '$codigo_vendedor'";
        try {
            $conexion->query($query);
        } catch (Exception $e) {
            if ($e->getCode() == 1451) {
                echo "<script>alert('No se puede eliminar el vendedor porque está asociado a otros registros.'); window.location.href = 'formulario.php?tabla=vendedor';</script>";
            }
            exit;
        }
        echo "<script>alert('Vendedor eliminado exitosamente.'); window.location.href = 'formulario.php?tabla=vendedor';</script>";
    }
    ?>



