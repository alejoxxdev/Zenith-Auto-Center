<?php include 'conexion.php';
    session_start();
    if (!isset($_SESSION['id_user'])) {
            header('Location: login/login.php');
        } else {
            $id_usuario = $_SESSION['id_user'];
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Stylos-Barra-Navegacion\inicio.css">
    <link rel="stylesheet" href="admin/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<style>
    body {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        background-color: #121212;
        color: #ddd;
        margin: 0;

    }

    .navbar {
        width: 100%;
        position: relative;
        margin-bottom: 20px;
    }

    .tabla-carrito {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .tabla-carrito th, .tabla-carrito td {
        border: 1px solid #ddd;
        padding: 8px;
        color: #ddd;
    }

    .footer {
        margin-top: auto;
        width: 100%;
    }

    main {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 60%;
    }
</style>

<body>
    <?php include 'header.php'; ?>
    <main>
    <h1>Factura</h1>
    <table class="tabla-carrito">
                <thead>
                    <th>ID</th>
                    <th>VEHICULO</th>
                    <th>PRECIO UNITARIO</th>
                    <th>SUBTOTAL</th>
                    <th>CANTIDAD</th>
                </thead>
                <tbody class="vehiculosañadidos">
                    <?php


                    

                    $carrito = json_decode($_POST['carrito'], true) ?? [];

                    $total = array_sum(array_column($carrito, 'precio'));
                    $totalCantidad = array_sum(array_column($carrito, 'cantidad'));
                    
                    foreach ($carrito as $vehiculo):
                    ?>
                    <tr>
                    <td><?php echo $vehiculo['id']; ?></td>
                    <td><?php echo $vehiculo['titulo']; ?></td>
                    <td><?php echo '$'. number_format($vehiculo['precioUnitario'], 2, '.', ' '); ?></td>
                    <td><?php echo '$'. number_format($vehiculo['precio'], 2, '.', ' '); ?></td>
                    <td><?php echo $vehiculo['cantidad']; ?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
                <tfoot></tfoot>
                    <tr>
                        <td colspan="3">Total:</td>
                        <td class="total-precio" style="font-weight: bold;"><?php echo '$' . number_format($total, 2, '.', ' '); ?></td>
                        <td class="total-cantidad" style="font-weight: bold;"><?php echo number_format($totalCantidad, 0, '.', ' '); ?></td>
                    </tr>
                </tfoot>
            </table>


            <form action="factura.php" method="post">

                <?php
                $sql = "SELECT * FROM cliente WHERE id_user1 = $id_usuario";
                $resultado = $conexion->query($sql);
                if($resultado && $resultado->num_rows == 0) :
                ?>

                <input type="hidden" name="carrito" value="<?php echo htmlspecialchars(json_encode($carrito), ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="form-submitted" value="1">
                <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
                <input type="hidden">

                <div class="form-group">
                    <label for="nombres">Nombres</label>
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

                <div class="form-group" style="text-align: center; margin-top: 20px;">
                    <button class="btn" type="submit">Comprar</button>
                </div>
                <?php else: ?>
                    <p style="text-align: center; margin-top: 20px;">Ya estas registrado como cliente. Solo da click en comprar.</p>
                    <input type="hidden" name="carrito" value="<?php echo htmlspecialchars(json_encode($carrito), ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="form-submitted" value="1">
                    <?php $cliente = $resultado->fetch_assoc(); ?>
                    <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">
                    
                    <div class="form-group" style="text-align: center; margin-top: 20px;">
                        <button class="btn" type="submit">Comprar</button>
                    </div>
                <?php endif; ?>
            </form>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>

<?php
    if (isset($_POST['form-submitted'])) {

        $carrito = json_decode($_POST['carrito'], true) ?? [];

        if (empty($carrito)) {
            die("El carrito está vacío.");
        }
        $total = array_sum(array_column($carrito, 'precio'));
        $fecha_compra = date('Y-m-d H:i:s');

        if (isset($_POST['id_cliente'])) {
            $id_cliente = $_POST['id_cliente'];
        }
        else {
            $id_usuario = $_POST['id_usuario'];
            $nombres = $_POST['nombres'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $ciudad = $_POST['ciudad'];

            $sql_cliente = "INSERT INTO cliente (nombre_cliente, telefono_cliente, gmail_cliente, direccion_cliente, ciudad, id_user1) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_cliente = $conexion->prepare($sql_cliente);
            $stmt_cliente->bind_param("sisssi", $nombres, $telefono, $email, $direccion, $ciudad, $id_usuario);

            if ($stmt_cliente->execute()) {
                $id_cliente = $stmt_cliente->insert_id;
            } else {
                die("Error al insertar cliente: " . $stmt_cliente->error);
            }
        }


        $sql_factura = "INSERT INTO factura (fecha_factura, total) VALUES (?, ?)";
        $stmt_factura = $conexion->prepare($sql_factura);
        $stmt_factura->bind_param("si", $fecha_compra, $total);

        if ($stmt_factura->execute()) {
            $id_factura = $stmt_factura->insert_id;
        } else {
            die("Error al insertar factura: " . $stmt_factura->error);
        }


        $sql_venta = "INSERT INTO venta (id_factura1, monto_final, id_cliente1) VALUES (?, ?, ?)";
        $stmt_venta = $conexion->prepare($sql_venta);

        $stmt_venta->bind_param("idi", $id_factura, $total, $id_cliente);
        if (!$stmt_venta->execute()) {
            die("Error al insertar venta: " . $stmt_venta->error);
        }


        foreach ($carrito as $vehiculo) {
            $sql_detalle = "INSERT INTO vehiculo_factura (id_factura1, id_vehiculo1, precio_unitario, cantidad, subtotal) 
                            VALUES (?, ?, ?, ?, ?)";
            $stmt_detalle = $conexion->prepare($sql_detalle);
            $subtotal = $vehiculo['precio'];
            $stmt_detalle->bind_param("iidid", 
                $id_factura,
                $vehiculo['id'],
                $vehiculo['precioUnitario'],
                $vehiculo['cantidad'],
                $subtotal
            );
            if (!$stmt_detalle->execute()) {
                die("Error al insertar detalle: " . $stmt_detalle->error);
            }
        }



        if (isset($stmt_detalle)) {
            $stmt_detalle->close();
        }
        $stmt_factura->close();
        if (isset($stmt_cliente) && !isset($id_cliente)) {
            $stmt_cliente->close();
        }
        $stmt_venta->close();
        $conexion->close();
        echo "<script>alert('Compra realizada con éxito.');</script> <script>window.location.href='index.php';</script>";

    }
?>