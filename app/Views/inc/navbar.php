<nav class="navbar">
    <div class="navbar-brand">
        <a class="navbar-item" href="<?php echo APP_URL; ?>dashboard/">
            <img src="<?php echo APP_URL; ?>" alt="" width="112" height="28">
        </a>
        <div class="navbar-burger" data-target="navbarExampleTransparentExample">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div id="navbarExampleTransparentExample" class="navbar-menu">

        <div class="navbar-start">
            <a class="navbar-item" href="#">
                Dashboard
            </a>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="#">
                    Usuarios
                </a>
                <div class="navbar-dropdown is-boxed">

                    <a class="navbar-item" href="<?php echo APP_URL; ?>nuevoUsuario/">
                        Nuevo
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>listaUsuario/">
                        Lista
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>buscarUsuario/">
                        Buscar
                    </a>

                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="#">
                    Negocios
                </a>
                <div class="navbar-dropdown is-boxed">

                    <a class="navbar-item" href="<?php echo APP_URL; ?>nuevoNegocio/">
                        Nuevo
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>listaNegocio/">
                        Lista
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>buscarNegocio/">
                        Buscar
                    </a>

                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="#">
                    Giro
                </a>
                <div class="navbar-dropdown is-boxed">

                    <a class="navbar-item" href="<?php echo APP_URL; ?>nuevoGiro/">
                        Nuevo
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>listaGiro/">
                        Lista
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>buscarGiro/">
                        Buscar
                    </a>

                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="#">
                    Tipo de servicio
                </a>
                <div class="navbar-dropdown is-boxed">

                    <a class="navbar-item" href="<?php echo APP_URL; ?>nuevoTipoServicio/">
                        Nuevo
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>listaTipoServicio/">
                        Lista
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>buscarTipoServicio/">
                        Buscar
                    </a>

                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="#">
                    Servicio
                </a>
                <div class="navbar-dropdown is-boxed">

                    <a class="navbar-item" href="<?php echo APP_URL; ?>nuevoServicio/">
                        Nuevo
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>listaServicio/">
                        Lista
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>buscarServicio/">
                        Buscar
                    </a>

                </div>
            </div>
        </div>

        <div class="navbar-end">
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    ** <?php echo $_SESSION["nombre_usuario"] . " ".$_SESSION["apellido_usuario"] ?> **
                </a>
                <div class="navbar-dropdown is-boxed">

                    <a class="navbar-item" href="<?php echo APP_URL; ?>actualizarUsuario/"<?php echo $_SESSION['id_usuario']?>>
                        Mi cuenta
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>fotoUsuario/<?php echo $_SESSION['id_usuario']?>">
                        Mi foto
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="<?php echo APP_URL; ?>cerrarSesion/" id="btn_exit" >
                        Salir
                    </a>

                </div>
            </div>
        </div>

    </div>
</nav>