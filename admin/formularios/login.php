
    <h2>Login</h2>

    <form action="formulario.php?tabla=login" method="post">
        <input type="hidden" name="tabla" value="login">
        <input type="hidden" name="accion" value="crear">


        <div class="form-group">
            <label for="username">Username:</label>
            <input class="form-control" type="text" id="username" name="username" placeholder="Ingresa el username" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input class="form-control" type="password" id="password" name="password" placeholder="Ingresa el password" required>
        </div>

        <div class="form-group">
            <label for="is_admin">Es admin:</label>
            <select name="is_admin" id="is_admin" class="form-control">
                <option value="0">No</option>
                <option value="1">Sí</option>
            </select>
        </div>

        <div class="form-group">
            <button class="btn" type="submit">Agregar login</button>
        </div>
    </form>

    <form action="formulario.php" method="get">
        <div class="form-group">
            <label for="buscar">Buscar login:</label>
            <input class="form-control" type="text" name="buscar" placeholder="Buscar login">
            <input type="hidden" name="tabla" value="login">
            <button class="btn" type="submit">Buscar</button>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Contraseña (hash)</th>
                <th>Es admin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
            $query = "SELECT * FROM login WHERE id_user LIKE '%$buscar%' OR username LIKE '%$buscar%' OR password LIKE '%$buscar%' OR is_admin LIKE '%$buscar%'";
            $resultado = $conexion->query($query);
            while ($login = $resultado->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $login['id_user']; ?></td>
                    <td><?php echo $login['username']; ?></td>
                    <td><?php echo  $login['password']; ?></td>
                    <td><?php echo $login['is_admin'] ? 'Sí' : 'No'; ?></td>
                    <td class="acciones">
                        <div class="botones-contenedor">
                            <form action="formulario.php" method="get" style="display: inline;">
                                <input type="hidden" name="tabla" value="login">
                                <input type="hidden" name="t_formulario" value="formularios_editar">
                                <input type="hidden" name="id_user" value="<?php echo $login['id_user']; ?>">
                                <button type="submit" class="btn-editar btn">Editar</button>
                            </form>
                            <form action="formulario.php?tabla=login" method="post" style="display: inline;">
                                <input type="hidden" name="id_user" value="<?php echo $login['id_user']; ?>">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="tabla" value="login">
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
        $username = $_POST['username'];

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $is_admin = $_POST['is_admin'];
        $query = "INSERT INTO login (username, password, is_admin) VALUES ('$username', '$password', '$is_admin')";
        $conexion->query($query);
        if ($conexion->error) {
            echo "<p>Error al agregar el login: " . $conexion->error . "</p>";
        } else {
            echo "<script>alert('Login agregado exitosamente.'); window.location.href = 'formulario.php?tabla=login';</script>";
        }
    } elseif ($accion == 'eliminar') {
        $id_user = $_POST['id_user'];
        $query = "DELETE FROM login WHERE id_user = '$id_user'";
        try {
            $conexion->query($query);
        } catch (Exception $e) {
            if ($e->getCode() == 1451) {
                echo "<script>alert('No se puede eliminar el login porque está asociado a otros registros.'); window.location.href = 'formulario.php?tabla=login';</script>";
            }
            exit;
        }
    }
    ?>
