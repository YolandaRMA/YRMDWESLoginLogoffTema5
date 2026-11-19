
<?php
/**
 * @author: Yolanda Rodríguez Moreno
 * @since: 18/11/2026
 * Proyecto Login Logoff Tema 5.
 *
 * Esta página permite acceder a la parte privada de la aplicación.
 * Comprueba que el usuario haya iniciado sesión y muestra su nombre,
 * el número de conexiones y la fecha de su conexión anterior.
 * También permite acceder a la página de detalle o cerrar la sesión.
 */
    // Se inicia la sesión para poder consultar los datos
    // del usuario que ha iniciado sesión.
    session_start();

    // Se comprueba si existe una sesión iniciada.
    // Si no existe, el usuario no puede acceder a esta página privada
    // y se le redirige al formulario de inicio de sesión.
    if (!isset($_SESSION['userYRMDWESLoginLogoffTema5'])) {
        header("Location: login.php");
        exit();
    }

    // Se recupera el idioma almacenado en la cookie cookieIdioma.
    // Si todavía no existe, se establece español por defecto.
    $idioma = $_COOKIE['cookieIdioma'] ?? 'es';

    // Se recuperan los datos del usuario que están guardados en la sesión.
    $aUsuario = $_SESSION['userYRMDWESLoginLogoffTema5'];

    // Se recupera la fecha de la conexión anterior.
    // Se guarda en una variable porque la fecha de la base de datos
    // ya se ha actualizado con la conexión que acaba de realizarse.
    $fechaUltimaConexion = $_SESSION['fechaHoraUltimaConexion'];

    // Se comprueba si se ha pulsado el botón Cerrar sesión.
    // Si se ha pulsado, se destruye la sesión y se vuelve a la página pública.
    if (isset($_POST['cerrarSesion'])) {

        // Se eliminan todas las variables almacenadas en la sesión.
        session_unset();

        // Se destruye la sesión actual.
        session_destroy();

        // Se redirige al usuario a la página de inicio pública.
        header("Location: ../indexProyectoLoginLogoffTema5.php");
        exit();
    }

    // Se comprueba si se ha pulsado el botón Detalle.
    // Si se ha pulsado, se accede a la página donde se muestran
    // las variables superglobales y la información de PHP.
    if (isset($_POST['detalle'])) {
        header("Location: detalle.php");
        exit();
    }

    // Se preparan los textos de la página según el idioma almacenado en la cookie.
    if ($idioma === 'pt') {

        $tituloPagina = "Área privada";
        $tituloSeccion = "Acesso privado";
        $textoBienvenida = "Bem-vindo/a";
        $textoPrimeraConexion = "Esta é a primeira vez que inicia sessão.";
        $textoNumeroConexiones = "Esta é a sua";
        $textoVezConexion = "vez que inicia sessão.";
        $textoUltimaConexion = "A sua ligação anterior foi em";
        $textoDetalle = "Detalhe";
        $textoCerrarSesion = "Terminar sessão";
    } else {

        $tituloPagina = "Área privada";
        $tituloSeccion = "Acceso privado";
        $textoBienvenida = "Bienvenido/a";
        $textoPrimeraConexion = "Esta es la primera vez que te conectas.";
        $textoNumeroConexiones = "Esta es la";
        $textoVezConexion = "vez que te conectas.";
        $textoUltimaConexion = "Tu última conexión anterior fue el";
        $textoDetalle = "Detalle";
        $textoCerrarSesion = "Cerrar sesión";
    }

    // Se transforma la fecha de la conexión anterior al formato día/mes/año y hora:minutos:segundos.
    // strtotime() convierte la fecha almacenada en una marca de tiempo
    // y date() permite mostrarla con el formato deseado.
    $fechaUltimaConexion = date('d/m/Y H:i:s', strtotime($fechaUltimaConexion));
    ?>

<!DOCTYPE html>
<html lang="<?php echo $idioma; ?>">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $tituloPagina; ?></title>
        <link rel="stylesheet" href="../webroot/css/estilos.css">
    </head>

    <body>

        <header>

            <div class="cabecera-logo">
                <img src="../webroot/images/logoCandado.jpg" alt="Logo Login Logoff">
            </div>

            <div class="cabecera-titulos">
                <h1><?php echo $tituloPagina; ?></h1>
            </div>

        </header>

        <main>
            <h2><?php echo $tituloSeccion; ?></h2>
            <div class="bienvenida">              
            <p class="bienvenida">
                <?php echo $textoBienvenida; ?>
                 <strong>
                     <?php echo $aUsuario['T01_DescUsuario']; ?>
                 </strong>
             </p>

        <?php
        // Si el número de conexiones es 1, significa que es el primer acceso
        // registrado del usuario y no se muestra una conexión anterior.
        if ($aUsuario['T01_NumConexiones'] == 1) {
            echo "<p class='datos-conexion'>" . $textoPrimeraConexion . "</p>";
        } else {
            // Si el usuario ya se ha conectado anteriormente,
            // se muestra el número de conexiones y la fecha de la conexión anterior.
            echo "<p class='datos-conexion'>";
            echo $textoNumeroConexiones . " <strong>"
            . $aUsuario['T01_NumConexiones'] . "</strong> "
            . $textoVezConexion . "<br>";
            echo $textoUltimaConexion . " <strong>"
            . $fechaUltimaConexion . "</strong>.</p>";
        }
        ?>
            </div>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="submit" name="detalle" id="detalle"
                       value="<?php echo $textoDetalle; ?>">
                <input type="submit" name="cerrarSesion" id="cerrarSesion"
                   value="<?php echo $textoCerrarSesion; ?>">
            </form>
        </main>
        <footer>
            <p><a href="../../YRMDWESProyectoDWES/indexProyectoDWES.php">Home</a></p>
            <div class="footer-text">
                <p>2026-27 IES Los Sauces. &copy; Todos los derechos reservados.
                    <a href="../../index.html">Yolanda Rodríguez Moreno</a></p>
                <time datetime="2026-11-18">Última actualización: 18 de Noviembre de 2026</time>
                <a class="icono" href="https://github.com/YolandaRMA/YRMDWESLoginLogoffTema5" target="_blank">
                    <img src="webroot/images/iconoGitHub.png" alt="">
                </a>
            </div>
        </footer>

    </body>
</html>
