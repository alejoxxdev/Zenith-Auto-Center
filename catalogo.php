<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Zenith Auto Center </title>
    <link rel="stylesheet" href="Stylos-Barra-Navegacion/catalogo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <p style="display: none;" id="user"><?php echo $_SESSION['usuario'] ?? ''; ?></p>
</head>
<body>
    <?php include 'header.php'; ?>
    <video muted autoplay loop>
                <source src="/img/bg-catalogo.mp4" type="video/mp4"/>
    </video>
    <div class="contenedor-principal" style="display: flex;">
            <!--Fondo-->
            
            <!--FIN DE FONDO-->
        
        <!--FIN BARRA DE NAVEGACION-->
        <!--INICIO DE LAS CARDS-->
        <!--BUSCAR CARTAS-->
        <input type="checkbox" id="check-carrito" class="check-carrito">
        <label for="check-carrito"><img src="imagenes-inicio/icono/carrito.png" alt="carrito" style="width: 50px;"></label>
        
        

        <div class="carrito-de-compras">
            <h4>carrito de compras</h4>
            <table class="tabla-carrito">
                <thead>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>VEHICULO</th>
                    <th>PRECIO UNITARIO</th>
                    <th>SUBTOTAL</th>
                    <th>CANTIDAD</th>
                </thead>
                <tbody class="vehiculosañadidos">
                </tbody>
                <tfoot></tfoot>
                    <tr>
                        <td colspan="4">Total:</td>
                        <td class="total-precio">$0.00</td>
                        <td class="total-cantidad">0</td>
                    </tr>
                </tfoot>
            </table>
                <button class="boton-comprar" onclick="comprar()">Comprar</button>
                <button class="boton-comprar" onclick="vaciarCarrito()">Vaciar</button>
        </div>

        <label for="check-busqueda" class="check-busqueda"><i class="fas fa-search"></i></label>
        <input type="checkbox" id="check-busqueda" class="check-busqueda">
        <div class="caja_carta_buscar">
            <h2 class="titulo_buscar">Navegar por</h2>
            <form action="catalogo.php" class="barra-busqueda" method="get">
                <input type="text" name="busqueda" placeholder="Buscar...">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
                <a href="catalogo.php" id="todos" class="texto_buscar">Todos los productos</a>
                <a href="catalogo.php?busqueda=autos" id="autos" class="texto_buscar">Autos</a>
                <a href="catalogo.php?busqueda=motos" id="motos" class="texto_buscar">Motos</a>
                <a href="catalogo.php?busqueda=camionetas" id="camionetas" class="texto_buscar">Camionetas</a>
        </div>
        <!--FIN DE BUSCAR CARTAS-->
        <!--CARDS VEHICULOS-->

        <div id="caja_grande" class="caja_grande"> 
            <?php
                $sql = isset($_GET['busqueda']) ? "SELECT * FROM vehiculo WHERE nombre_vehiculo LIKE '%" . $_GET['busqueda'] . "%' OR categoria = '" . $_GET['busqueda'] . "'" : "SELECT * FROM vehiculo";
                $result = $conexion->query($sql);
                while ($row = $result->fetch_assoc()) : ?>
                    <div class="carta">
                        <div class="imagen-zona">
                            <img src="<?php echo $row['imagen']; ?>" alt="<?php echo $row['marca'] . ' ' . $row['modelo']; ?>">
                            <div class="cobertura">
                                <button class="añade-carro" onclick="Añadiralcarrito(this)" id="<?php echo $row['id_vehiculo']; ?>">Agregar al carrito</button>
                            </div>
                        </div>

                        <div class="descripcion">
                            <p class="categoria" style="display: none;"><?php echo $row['categoria']; ?></p>
                            <h3 class="titulo"><?php echo $row['nombre_vehiculo']; ?></h3>
                            <p class="precio">$<?php echo number_format($row['precio_venta_vehiculo'], 0, ',', '.'); ?></p>
                            <p><?php echo $row['detalles_vehiculo']; ?></p>
                        </div>
                    </div>
            <?php endwhile; ?>
        </div>
        
        <!--FIN FOOTER-->


    </div>
    <?php include 'footer.php' ?>
    <script src="javascript/catalogo.js" defer></script>
</body>
</html>
