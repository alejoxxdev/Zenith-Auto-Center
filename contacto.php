<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Zenith Auto Center </title>
    <link rel="stylesheet" href="Stylos-Barra-Navegacion/Contacto.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
    <div class="contenedor-principal">
        <!--BARRA DE NAVEGACION CON LOGO-->
        <?php include 'header.php'; ?>
            <!--CONTENIDO PRINCIPAL-->


        <!--CONTACTANOS-->
        <div class="contact-form-container">
            <h1>Contáctanos</h1>
            <form action="contacto.php" method="post" class="contact-form">
                <input type="hidden" name="accion" value="crear">
                <label for="name">Nombre:</label>
                <input type="text" id="nombres" name="nombre" placeholder="Tu nombre" required>
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" placeholder="Tu correo electrónico" required>
                <label for="subject">Asunto:</label>
                <input type="text" id="subject" name="asunto" placeholder="Asunto del mensaje" required>
                <label for="message">Mensaje:</label>
                <textarea id="message" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
    <!--INICIO FOOTER-->
    <?php include 'footer.php'; ?>
        <!--FIN FOOTER-->
</body>
</html>

<?php
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    if ($accion == 'crear') {
        $nombre = $_POST['nombre'];
        $correo = $_POST['email'];
        $asunto = $_POST['asunto'];
        $mensaje = $_POST['mensaje'];

        $sql = "INSERT INTO sugerencia (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $correo, $asunto, $mensaje);
        if ($stmt->execute()) {
            echo "<script>alert('Sugerencia agregada exitosamente.'); window.location.href = 'contacto.php';</script>";
        } else {
            echo "<script>alert('Error al agregar la sugerencia: " . $stmt->error . "');</script>";
        }
    }

?>