<?php
include("../conexion.php");
include("verificar.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Stylos-Barra-Navegacion/inicio.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../../Stylos-Barra-Navegacion/formularioCrearVehiculo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="../js/catalogo.js" defer></script>
</head>

<body>
    <div class="bg-admin">
    </div>
    <?php include 'header.php' ?>
    <h1 class="titulo-admin">Formulario de administración</h1>
    <nav class="admin-nav">
        <ul>
            <li><a href="formulario.php?tabla=proveedor&t_formulario=formularios">Proveedor</a></li>
            <li><a href="formulario.php?tabla=ventas&t_formulario=formularios">Venta</a></li>
            <li><a href="formulario.php?tabla=vendedor&t_formulario=formularios">Vendedor</a></li>
            <li><a href="formulario.php?tabla=vehiculo&t_formulario=formularios">Vehiculo</a></li>
            <li><a href="formulario.php?tabla=factura&t_formulario=formularios">Factura</a></li>
            <li><a href="formulario.php?tabla=v_factura&t_formulario=formularios">Vehiculos en facturas</a></li>
            <li><a href="formulario.php?tabla=cliente&t_formulario=formularios">Cliente</a></li>
            <li><a href="formulario.php?tabla=login&t_formulario=formularios">Usuario</a></li>
            <li><a href="formulario.php?tabla=sugerencia&t_formulario=formularios">Sugerencia</a></li>
        </ul>
    </nav>
    <section class="form-container">
        <?php
        $tabla = $_GET['tabla'] ?? 'vehiculo';
        $t_formulario = $_GET['t_formulario'] ?? 'formularios';

        include "$t_formulario/$tabla.php";
        ?>

    </section>
    <?php include 'footer.php' ?>

</body>

</html>