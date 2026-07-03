<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Zenith Auto Center </title>
    <link rel="stylesheet" href="Stylos-Barra-Navegacion/Inicio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
    <div class="contenedor-principal">
        <!--BARRA DE NAVEGACION CON LOGO-->
        <?php include 'header.php'; ?>
        <!--INICIO CARRUSEL-->
        <div class="contenedor-carrusel-imagenes">
            <div class="contenedor-carrusel">
                <div class="imagen1"><h2> CALIDAD </h2></div>
                <div class="imagen2"><h2> CONFIANZA </h2></div>
                <div class="imagen3"><h2> ESTILO </h2></div>
            </div> 
        </div> <!--FIN CARRUSEL-->

        <!--SECCION DE CARROS Y FRASES-->
        <h2 class="frase_titulo">Más que un auto, es tu pase a nuevas aventuras.</h2>
        <div class="caja_img_grande">
            <div class="caja_imagen">
                <img src="/imagenes-inicio/imagenes-decoracion/diversion/perrito.jpg">
            </div>
            <div class="caja_imagen">
                <img src="/imagenes-inicio/imagenes-decoracion/diversion/sombrero-ventana.jpg">
            </div>
            <div class="caja_imagen">
                <img src="/imagenes-inicio/imagenes-decoracion/diversion/deportivo.avif">
            </div>
        </div>

        <h2 class="frase_titulo">El auto que siempre imaginaste, ahora es real.</h2>
        <div class="caja_boton">
            <a href="catalogo.php"><h2 class="boton_frase">Tu auto soñado te está esperando.</h2></a>
        </div>
        <!--COLLAGE-->
        <div class="caja_collage">
            <div class="collage collage1">
                <img src="/imagenes-inicio/imagenes-decoracion/collage/autos.webp" alt="">
            </div>
            <div class="collage collage2">
                <img src="/imagenes-inicio/imagenes-decoracion/collage/farola.avif" alt="">
            </div>
            <div class="collage collage3">
                <img src="/imagenes-inicio/imagenes-decoracion/collage/mustang.jpg" alt="">
            </div>
            <div class="collage collage4">
                <img src="/imagenes-inicio/imagenes-decoracion/collage/tacometro.jpg" alt="">
            </div>
        </div>
        <!--FIN COLLAGE-->
        <h2 class="frase_titulo">Donde tus sueños comienzan, tu auto ideal ya está listo.</h2>
        <!--COLLAGE 2-->
        <div class="caja_collagee">
            <div class="collagee collagee1">
                <img src="/imagenes-inicio/imagenes-decoracion/carros/audi.avif" alt="">
            </div>
            <div class="collagee collagee2">
                <img src="imagenes-inicio/imagenes-decoracion/carros/photo-1552519507-da3b142c6e3d.avif" alt="">
            </div>
            <div class="collagee collagee3">
                <img src="/imagenes-inicio/imagenes-decoracion/carros/trasero-audi.avif" alt="">
            </div>
            <div class="collagee collagee4">
                <img src="/imagenes-inicio/imagenes-decoracion/carros/mercedez.avif" alt="">
            </div>
            <div class="collagee collagee4">
                <img src="imagenes-inicio/imagenes-decoracion/carros/photo-1525609004556-c46c7d6cf023.avif" alt="">
            </div>
            <div class="collagee collagee4">
                <img src="imagenes-inicio/imagenes-decoracion/carros/photo-1588258219511-64eb629cb833.avif" alt="">
            </div>
            <div class="collagee collagee4">
                <img src="imagenes-inicio/imagenes-decoracion/carros/photo-1580273916550-e323be2ae537.avif" alt="">
            </div>
            <div class="collagee collagee4">
                <img src="imagenes-inicio/imagenes-decoracion/carros/photo-1580273916550-e323be2ae537.avif" alt="">
            </div>
        </div>
        <!--FIN COLLAGE 2-->
        <!-- FIN SECCION DE CARROS Y FRASES-->


        <!--INICIO FOOTER-->
        <?php include 'footer.php'; ?>
        <!--FIN FOOTER-->
    </div>
</body>
</html>
