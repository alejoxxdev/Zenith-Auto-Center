<?php
if (isset($_GET['id_cliente'])) {
    $id_cliente = $_GET['id_cliente'];
    $sql = "SELECT * FROM cliente WHERE id_cliente = $id_cliente";
    $resultado = $conexion->query($sql);
    $cliente = $resultado->fetch_assoc();
}
?>
<h2>Editar Cliente</h2>
<form action="formulario.php?tabla=cliente&t_formulario=formularios_editar" method="post">
    <input type="hidden" name="tabla" value="cliente">
    <input type="hidden" name="accion" value="editar">
    <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">

    <div class="form-group">
        <label for="nombre_cliente">Nombre cliente:</label>
        <input class="form-control" type="text" id="nombre_cliente" name="nombre_cliente" 
               value="<?php echo htmlspecialchars($cliente['nombre_cliente']); ?>" required>
    </div>

    <div class="form-group">
        <label for="telefono_cliente">Teléfono:</label>
        <input class="form-control" type="text" id="telefono_cliente" name="telefono_cliente" 
               pattern="[0-9]+" value="<?php echo htmlspecialchars($cliente['telefono_cliente']); ?>" required>
    </div>

    <div class="form-group">
        <label for="gmail_cliente">Email:</label>
        <input class="form-control" type="email" id="gmail_cliente" name="gmail_cliente" 
               value="<?php echo htmlspecialchars($cliente['gmail_cliente']); ?>" required>
    </div>

    <div class="form-group">
        <label for="direccion_cliente">Dirección:</label>
        <input class="form-control" type="text" id="direccion_cliente" name="direccion_cliente" 
               value="<?php echo htmlspecialchars($cliente['direccion_cliente']); ?>" required>
    </div>

    <div class="form-group">
        <label for="ciudad">Ciudad:</label>
        <input class="form-control" type="text" id="ciudad" name="ciudad" 
               value="<?php echo htmlspecialchars($cliente['ciudad']); ?>" required>
    </div>

    <div class="form-group">
        <label for="id_user1">Usuario:</label>
        <select name="id_user1" id="id_user1" class="form-control" required>
            <option value="" disabled>Selecciona un usuario</option>
            <?php
            $query = "SELECT id_user, username FROM login";
            $resultado_users = $conexion->query($query);
            while ($user = $resultado_users->fetch_assoc()):
            ?>
                <option value="<?php echo $user['id_user']; ?>" 
                    <?php echo ($user['id_user'] == $cliente['id_user1']) ? 'selected' : ''; ?>>
                    <?php echo $user['username']; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <button class="btn" type="submit">Editar Cliente</button>
    </div>
</form>

<?php
$accion = $_POST['accion'] ?? '';
if ($accion === 'editar') {
    $id_cliente = $_POST['id_cliente'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $telefono_cliente = $_POST['telefono_cliente'];
    $gmail_cliente = $_POST['gmail_cliente'];
    $direccion_cliente = $_POST['direccion_cliente'];
    $ciudad = $_POST['ciudad'];
    $id_user1 = $_POST['id_user1'];

    $sql = "UPDATE cliente SET 
            nombre_cliente = '$nombre_cliente', 
            telefono_cliente = '$telefono_cliente', 
            gmail_cliente = '$gmail_cliente', 
            direccion_cliente = '$direccion_cliente', 
            ciudad = '$ciudad', 
            id_user1 = '$id_user1' 
            WHERE id_cliente = $id_cliente";

    if ($conexion->query($sql) === TRUE) {
        echo "<script>alert('Cliente actualizado correctamente.'); window.location.href = 'formulario.php?tabla=cliente';</script>";
    } else {
        echo "<script>alert('Error al actualizar el cliente: " . addslashes($conexion->error) . "');</script>";
    }
}
?>