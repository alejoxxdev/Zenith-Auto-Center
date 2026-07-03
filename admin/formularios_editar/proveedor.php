<?php
   if (isset($_GET['RUT_proveedor'])) {
       $RUT_proveedor = $_GET['RUT_proveedor'];
       $sql = "SELECT * FROM proveedor WHERE RUT_proveedor = '$RUT_proveedor'";
       $resultado = $conexion->query($sql);
       $proveedor = $resultado->fetch_assoc();
   }
?>

<h2>Proveedor</h2>

<form action="formulario.php?tabla=proveedor&t_formulario=formularios_editar" method="post">
    <input type="hidden" name="tabla" value="proveedor" class="form-group">
    <input type="hidden" name="accion" value="editar">
    <input type="hidden" name="oRUT_proveedor" value="<?php echo $proveedor['RUT_proveedor'] ?>">

    <div class="form-group">
        <label for="nombres">RUT proveedor:</label>
        <input class="form-control" type="text" id="RUT_proveedor" name="RUT_proveedor" placeholder="Ingresa el RUT proveedor" value="<?php echo $proveedor['RUT_proveedor'] ?>" required>
    </div>

    <div class="form-group">
        <label for="apellidos">Nombre:</label>
        <input class="form-control" type="text" id="nombre_proveedor" name="nombre_proveedor" placeholder="Ingresa el nombre" value="<?php echo $proveedor['nombre_proveedor']?>" required>
    </div>

    <div class="form-group">
        <label for="direccion">Dirección:</label>
        <input class="form-control" type="text" id="direccion_proveedor" name="direccion_proveedor" placeholder="Ingresa la dirección" value="<?php echo $proveedor['direccion_proveedor']?>" required>
    </div>

    <div class="form-group">
        <label for="celular">Telefono:</label>
        <input class="form-control" type="number" id="telefono_proveedor" name="telefono_proveedor" pattern="[0-9]{9}" placeholder="Ingresa el telefono" value="<?php echo $proveedor['telefono_proveedor']?>" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input class="form-control" type="email" id="email_proveedor" name="email_proveedor" placeholder="Ingresa el email" value="<?php echo $proveedor['email_proveedor']?>" required>
    </div>

    <div class="form-group">
        <label for="redes">Redes sociales:</label>
        <input class="form-control" type="text" id="RedesSociales_proveedor" name="RedesSociales_proveedor" placeholder="Ingresa las redes sociales" value="<?php echo $proveedor['RedesSociales_proveedor']?>" required>
        <button class="btn" type="submit">Editar Proveedor</button>
    </div>
</form>

<?php
$accion = isset($_POST['accion']) ? $_POST['accion'] : '';
if ($accion === 'editar') {
    $oRUT_proveedor = $_POST['oRUT_proveedor'];
    $RUT_proveedor = $_POST['RUT_proveedor'];
    $nombre_proveedor = $_POST['nombre_proveedor'];
    $direccion_proveedor = $_POST['direccion_proveedor'];
    $telefono_proveedor = $_POST['telefono_proveedor'];
    $email_proveedor = $_POST['email_proveedor'];
    $RedesSociales_proveedor = $_POST['RedesSociales_proveedor'];

    if ($RUT_proveedor !== $oRUT_proveedor) {
        if ($conexion->query("SELECT * FROM proveedor WHERE RUT_proveedor = '$RUT_proveedor'")->num_rows > 0) {
            echo "<script>alert('El RUT del proveedor ya existe. Por favor, ingresa uno diferente.'); window.location.href = 'formulario.php?tabla=proveedor&t_formulario=formularios_editar&RUT_proveedor=$RUT_proveedor';</script>";
            exit;
        }
    }

    $sql = "UPDATE proveedor SET 
            RUT_proveedor = '$RUT_proveedor', 
            nombre_proveedor = '$nombre_proveedor', 
            direccion_proveedor = '$direccion_proveedor', 
            telefono_proveedor = '$telefono_proveedor', 
            email_proveedor = '$email_proveedor', 
            RedesSociales_proveedor = '$RedesSociales_proveedor' 
            WHERE RUT_proveedor = '$oRUT_proveedor'";

    if ($conexion->query($sql)) {
        echo "<script>alert('Proveedor actualizado correctamente'); window.location.href = 'formulario.php?tabla=proveedor';</script>";
    } else {
        echo "<script>alert('Error al actualizar el proveedor');</script>";
    }
}
?>