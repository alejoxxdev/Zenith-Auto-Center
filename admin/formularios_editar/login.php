<?php
    if (isset($_GET['id_user'])) {
        $id_user = $_GET['id_user'];
        $sql = "SELECT * FROM login WHERE id_user = $id_user";
        $result = $conexion->query($sql);
        $login = $result->fetch_assoc();
    } 
?>
<h2>Editar Login</h2>
<form  action="formulario.php?tabla=login&t_formulario=formularios_editar" method="post">
    <input type="hidden" name="tabla" value="login">
    <input type="hidden" name="accion" value="editar">
    <input type="hidden" name="id_user" value="<?php echo $login['id_user']; ?>">

    <div class="form-group">
        <label for="username">Username:</label>
        <input class="form-control" type="text" id="username" name="username" placeholder="Ingresa el username" value="<?php echo $login['username']; ?>" required>
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input class="form-control" type="password" id="password" name="password" placeholder="Ingresa el password" value="" required>
    </div>

    <div class="form-group">
        <label for="is_admin">Es admin :</label>
        <select name="is_admin" id="is_admin" class="form-control">
            <option value="0" <?php echo $login['is_admin'] == 0 ? 'selected' : ''; ?>>No</option>
            <option value="1" <?php echo $login['is_admin'] == 1 ? 'selected' : ''; ?>>Sí</option>
        </select>
    </div>

    <div class="form-group">
        <button class="btn" type="submit">Editar login</button>
    </div>
</form>

<?php
$accion = $_POST['accion'] ?? '';

if ($accion === 'editar') {
    $id_user = $_POST['id_user'] ?? null;
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $is_admin = $_POST['is_admin'] ?? 0;

    if ($id_user === null) {
        echo "ID de usuario no proporcionado.";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $query = "UPDATE login SET username = '$username', password = '$hashed_password', is_admin = $is_admin WHERE id_user = $id_user";
    $conexion->query($query);
    if ($conexion->error) {
        echo "Error al actualizar el login: " . $conexion->error;
        exit;
    } else {
        echo "<script>alert('Login actualizado correctamente.'); window.location.href = 'formulario.php?tabla=login';</script>";
    }
}
?>