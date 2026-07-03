<h2>Sugerencia</h2>

    <form action="formulario.php?tabla=sugerencia" method="post">
        <input type="hidden" name="tabla" value="sugerencia">
        <input type="hidden" name="accion" value="crear">

        


        <div class="form-group">
            <label for="nombre">Nombres y apellidos:</label>
            <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Ingresa tus nombres" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input class="form-control" type="email" id="email" name="email" placeholder="Ingresa el email" required>
        </div>

        <div class="form-group">
            <label for="asunto">Asunto:</label>
            <input class="form-control" type="text" id="asunto" name="asunto" placeholder="Ingresa el asunto" required>
        </div>

        <div class="form-group">
            <label for="mensaje">Mensaje:</label>
            <textarea class="form-control" id="mensaje" name="mensaje" rows="4" placeholder="Ingresa tu mensaje" required></textarea>
        </div>

        

        <div class="form-group">
            <button class="btn" type="submit">Agregar Sugerencia</button>
        </div>
    </form>

    <form action="formulario.php" method="get">
        <div class="form-group">
            <input type="hidden" name="tabla" value="sugerencia">
            <label for="buscar">Buscar sugerencia:</label>
            <input class="form-control" type="text" name="buscar" placeholder="Buscar sugerencia">
            <button class="btn" type="submit">Buscar</button>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>CORREO</th>
                <th>ASUNTO</th>
                <th>MENSAJE</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
            $query = "SELECT * FROM sugerencia WHERE nombre LIKE '%$buscar%' OR correo LIKE '%$buscar%' OR asunto LIKE '%$buscar%' OR mensaje LIKE '%$buscar%'";
            $resultado = $conexion->query($query);
            while ($sugerencia = $resultado->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $sugerencia['id_sugerencia']; ?></td>
                    <td><?php echo $sugerencia['nombre']; ?></td>
                    <td><?php echo $sugerencia['correo']; ?></td>
                    <td><?php echo $sugerencia['asunto']; ?></td>
                    <td><?php echo $sugerencia['mensaje']; ?></td>
                    
                    <td class="acciones">
                        <div class="botones-contenedor">
                            <form action="formulario.php" method="get" style="display: inline;">
                                <input type="hidden" name="tabla" value="sugerencia">
                                <input type="hidden" name="t_formulario" value="formularios_editar">
                                <input type="hidden" name="id_sugerencia" value="<?php echo $sugerencia['id_sugerencia']; ?>">
                                <button type="submit" class="btn btn-editar">Editar</button>
                            </form>
                            <form action="formulario.php?tabla=sugerencia" method="post" style="display: inline;">
                                <input type="hidden" name="id_sugerencia" value="<?php echo $sugerencia['id_sugerencia']; ?>">
                                <input type="hidden" name="accion" value="eliminar">
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
        $nombre = $_POST['nombre'];
        $correo = $_POST['email'];
        $asunto = $_POST['asunto'];
        $mensaje = $_POST['mensaje'];

        $query = "INSERT INTO sugerencia (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ssss", $nombre, $correo, $asunto, $mensaje);
        if ($stmt->execute()) {
            echo "<script>alert('Sugerencia agregada exitosamente.'); window.location.href = 'formulario.php?tabla=sugerencia';</script>";
        } else {
            echo "<p>Error al agregar la sugerencia: " . $stmt->error . "</p>";
        }
    } elseif ($accion == 'eliminar') {
        $id_sugerencia = $_POST['id_sugerencia'];
        $query = "DELETE FROM sugerencia WHERE id_sugerencia = '$id_sugerencia'";
        $conexion->query($query);
        if ($conexion->error) {
            echo "<p>Error al eliminar la sugerencia: " . $conexion->error . "</p>";
        } else {
            echo "<script>alert('Sugerencia eliminada exitosamente.'); window.location.href = 'formulario.php?tabla=sugerencia';</script>";
        }
    }
    ?>