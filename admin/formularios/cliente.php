
    <h2>Cliente</h2>

    <form action="formulario.php?tabla=cliente" method="post">
        <input type="hidden" name="tabla" value="clientes">
        <input type="hidden" name="accion" value="crear">

        


        <div class="form-group">
            <label for="nombres">Nombres y apellidos:</label>
            <input class="form-control" type="text" id="nombres" name="nombres" placeholder="Ingresa tus nombres" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input class="form-control" type="email" id="email" name="email" placeholder="Ingresa el email" required>
        </div>

        <div class="form-group">
            <label for="telefono">Telefono:</label>
            <input class="form-control" type="text" id="telefono" name="telefono" pattern="[0-9]+" placeholder="Ingresa tu telefono" required>
        </div>

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input class="form-control" type="text" id="direccion" name="direccion" placeholder="Ingresa la dirección" required>
        </div>

        <div class="form-group">
            <label for="ciudad">Ciudad:</label>
            <input class="form-control" type="text" id="ciudad" name="ciudad" placeholder="Ingresa la ciudad" required>
        </div>

        <div class="form-group">
            <label for="id_user1">Id user:</label>
            <select name="id_user1" id="id_user1" class="form-control" required>
                <option value="" disabled selected>Selecciona un usuario</option>
                <?php
                $query = "SELECT id_user, username FROM login";
                $resultado = $conexion->query($query);
                while ($user = $resultado->fetch_assoc()):
                ?>
                    <option value="<?php echo $user['id_user']; ?>"><?php echo $user['username']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <button class="btn" type="submit">Agregar Cliente</button>
        </div>
    </form>

    <form action="formulario.php" method="get">
        <div class="form-group">
            <input type="hidden" name="tabla" value="cliente">
            <label for="buscar">Buscar cliente:</label>
            <input class="form-control" type="text" name="buscar" placeholder="Buscar cliente">
            <button class="btn" type="submit">Buscar</button>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Dirección</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Ciudad</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
            $query = "SELECT * FROM cliente WHERE nombre_cliente LIKE '%$buscar%' OR direccion_cliente LIKE '%$buscar%' OR telefono_cliente LIKE '%$buscar%' OR gmail_cliente LIKE '%$buscar%' OR ciudad LIKE '%$buscar%'";
            $resultado = $conexion->query($query);
            while ($cliente = $resultado->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $cliente['id_cliente']; ?></td>
                    <td><?php echo $cliente['nombre_cliente']; ?></td>
                    <td><?php echo $cliente['direccion_cliente']; ?></td>
                    <td><?php echo $cliente['telefono_cliente']; ?></td>
                    <td><?php echo $cliente['gmail_cliente']; ?></td>
                    <td><?php echo $cliente['ciudad']; ?></td>
                    <td><?php echo $conexion->query("SELECT username FROM login WHERE id_user = " . $cliente['id_user1'])->fetch_assoc()['username']; ?></td>
                    <td class="acciones">
                        <div class="botones-contenedor">
                            <form action="formulario.php" method="get" style="display: inline;">
                                <input type="hidden" name="tabla" value="cliente">
                                <input type="hidden" name="t_formulario" value="formularios_editar">
                                <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">
                                <button type="submit" class="btn btn-editar">Editar</button>
                            </form>
                            <form action="formulario.php?tabla=cliente" method="post" style="display: inline;">
                                <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">
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
        $nombres = $_POST['nombres'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $ciudad = $_POST['ciudad'];
        $id_user1 = $_POST['id_user1'];
        $query = "INSERT INTO cliente (nombre_cliente, direccion_cliente, telefono_cliente, gmail_cliente, ciudad, id_user1) VALUES ('$nombres', '$direccion', '$telefono', '$email', '$ciudad', '$id_user1')";
        $conexion->query($query);
        if ($conexion->error) {
            echo "<p>Error al agregar el cliente: " . $conexion->error . "</p>";
        } else {
            echo "<script>alert('Cliente agregado exitosamente.'); window.location.href = 'formulario.php?tabla=cliente';</script>";
        }
    } elseif ($accion == 'eliminar') {
        $id_cliente = $_POST['id_cliente'];
        $query = "DELETE FROM cliente WHERE id_cliente = '$id_cliente'";
        try {
            $conexion->query($query);
            echo "<script>alert('Cliente eliminado exitosamente.'); window.location.href = 'formulario.php?tabla=cliente';</script>";
        } catch (Exception $e) {
            if ($e->getCode() == 1451) {
                echo "<script>alert('No se puede eliminar el cliente porque está asociado a otras tablas.'); window.location.href = 'formulario.php?tabla=cliente';</script>";
            } else {
                echo "<script>alert('Error al eliminar el cliente: " . $e->getMessage() . "'); window.location.href = 'formulario.php?tabla=cliente';</script>";
            }
        }
        
    }
    ?>
