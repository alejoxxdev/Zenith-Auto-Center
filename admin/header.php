<header class="navbar">
            <!--LOGO DE LA EMPRESA-->
            <div class="navbar-logo">
                <img src="/imagenes-inicio/Logo Proyecto.jpg" alt="logo" width="100px">
            </div>
            <!--FIN LOGO DE LA EMPRESA-->
            
            <!--HACER AQUI EL MENU HAMBURGUESA-->
            <div class="navbar-hamburger">
            </div>
            <!--FIN MENU HAMBURGUESA-->
            <!--ELEMENTOS MENU NAVEGACION-->
            <input type="checkbox" id="check" class="hamburguesa">
            <label for="check" class="abrir-menu"> <i class="fas fa-bars"></i> </label>
            
            <ul class="navbar-menu">
                <li><a href="../index.php" class="navbar-link"> INICIO </a></li>
                <li><a href="../catalogo.php" class="navbar-link"> CATÁLOGO </a></li>
                <li><a href="../servicios.php" class="navbar-link"> SERVICIOS </a></li>
                <li><a href="../contacto.php" class="navbar-link"> CONTACTO </a></li>
                <li><a href="../nosotros.php" class="navbar-link"> NOSOTROS </a></li>
                <?php if (isset($_SESSION['username'])): ?>

                    <li><a href="../login/logout.php" class="login-button"> CERRAR SESIÓN </a></li>
                    
                    <?php if ($_SESSION['is_admin'] === 1): ?>
                        <li><a href="formulario.php" class="login-button"> ADMIN </a></li>
                    <?php endif; ?>
                    <div style="display:flex; align-items: center; gap: 10px;">
                    <li><p style="font-size: 1.7rem;"><?php echo $_SESSION['username']; ?></p></li>
                    <div class="navbar-logo">
                        <img src="https://img.freepik.com/premium-vector/silver-membership-icon-default-avatar-profile-icon-membership-icon-social-media-user-image-vector-illustration_561158-4215.jpg?semt=ais_hybrid&w=740&q=80" alt="logo" width="60px">
                    </div>
                    </div>
                    <?php else: ?>
                        <li><a href="../login/login.php" class="login-button"> INICIAR SESION </a></li>
                <?php endif; ?>
            </ul>
            <!--FIN ELEMENTOS MENU NAVEGACION-->

            <!--INICIO BARRA DE NAVEGACION PARA CELULAR-->
            <div class="navbar-mobile">
                <ul class="mobile-menu">
                    <li><a href="../index.php" class="mobile-link"> INICIO </a></li>
                    <li><a href="../catalogo.php" class="mobile-link"> CATÁLOGO </a></li>
                    <li><a href="../servicios.php" class="mobile-link"> SERVICIOS </a></li>
                    <li><a href="../contacto.php" class="mobile-link"> CONTACTO </a></li>
                    <li><a href="../nosotros.php" class="mobile-link"> NOSOTROS </a></li>
                    <?php if (isset($_SESSION['username'])): ?>

                    <li><a href="../login/logout.php" class="login-button"> CERRAR SESIÓN </a></li>
                    
                    <?php if ($_SESSION['is_admin'] === 1): ?>
                        <li><a href="../admin/formulario.php" class="login-button"> ADMIN </a></li>
                    <?php endif; ?>
                    <div style="display:flex; align-items: center; gap: 10px;">
                    <li><p style="font-size: 1.7rem;"><?php echo $_SESSION['username']; ?></p></li>
                    <div class="navbar-logo">
                        <img src="https://img.freepik.com/premium-vector/silver-membership-icon-default-avatar-profile-icon-membership-icon-social-media-user-image-vector-illustration_561158-4215.jpg?semt=ais_hybrid&w=740&q=80" alt="logo" width="60px">
                    </div>
                    </div>
                    <?php else: ?>
                        <li><a href="../login/login.php" class="login-button"> INICIAR SESION </a></li>
                <?php endif; ?>
                </ul>
            </div>
            <!--FIN BARRA DE NAVEGACION PARA CELULAR-->
</header>

<style>

.navbar-menu {
    align-items: center;
}

.login-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #000000ff; /* Color de fondo */
    color: white; /* Color del texto */
    text-decoration: none; /* Eliminar subrayado */
    border: solid 2px white; /* Borde blanco */
    font-weight: bold; /* Texto en negrita */
}

.login-button:hover {
    background-color: #404040ff; /* Color de fondo al pasar el mouse */
    transition: background-color 0.5s ease; /* Transición suave */
    border: solid 2px white; /* Borde blanco al pasar el mouse */
}

.navbar {
    position: relative;
    z-index: 0;

}
</style>