
<?php
/**
 * @author: Yolanda Rodríguez Moreno
 * @since: 16/11/2026
 * Proyecto Login Logoff Tema 5.
 */

// Se comprueba si se ha seleccionado un idioma.
// Se admiten únicamente los idiomas español y portugués.
if (isset($_REQUEST['idioma']) && in_array($_REQUEST['idioma'], ['es', 'pt'])) {

    // Se crea una cookie llamada cookieIdioma para guardar el idioma elegido.
    // setcookie() recibe el nombre, el valor y el tiempo de duración de la cookie.
    // En este caso, se conserva durante 30 días.
    setcookie('cookieIdioma', $_REQUEST['idioma'], time() + (30 * 24 * 60 * 60), '/');

    // Se actualiza también la variable para mostrar inmediatamente el idioma elegido.
    $idioma = $_REQUEST['idioma'];

} else {

    // Se recupera el idioma almacenado en la cookie.
    // Si todavía no existe, se establece español por defecto.
    $idioma = $_COOKIE['cookieIdioma'] ?? 'es';
}

// Se comprueba si se ha pulsado el botón para acceder al login.
// Si se ha pulsado, se redirige al usuario a la página login.php.
if (isset($_REQUEST['login'])) {
    header("Location: codigoPHP/login.php");
    exit();
}

// Se preparan los textos que se mostrarán según el idioma seleccionado.
if ($idioma === 'pt') {
    $tituloPagina = "Início público";
    $textoBotonLogin = "Iniciar sessão";
    $textoHome = "Início";
    $textoDerechos = "Todos os direitos reservados.";
    $textoIdioma = "IDIOMA";
    $textoUltimaActualizacion = "Última atualização:";
} else {
    $tituloPagina = "Inicio público";
    $textoBotonLogin = "Iniciar sesión";
    $textoHome = "Home";
    $textoDerechos = "Todos los derechos reservados.";
    $textoIdioma = "IDIOMA";
    $textoUltimaActualizacion = "Última actualización:";
}
?>

<!DOCTYPE html>
<html lang="<?php echo $idioma; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloPagina; ?></title>
    <link rel="stylesheet" href="webroot/css/estilos.css">
</head>

<body>
    <header>
        <div class="cabecera-logo">
            <img src="webroot/images/logoCandado.jpg" alt="Logo Login Logoff">
            <br>
        </div>
        <div class="cabecera-titulos">
            <h1><?php echo $tituloPagina; ?></h1>
        </div>
        <!-- Selector para cambiar el idioma de la aplicación. -->
        <div class="selector-idioma">

            <span><?php echo $textoIdioma; ?></span>

            <!-- Cada enlace permite seleccionar un idioma y guardarlo en la cookie. -->
            <a href="?idioma=es" title="Español">
                <img src="webroot/images/banderaEspana.svg" alt="Español">
            </a>

            <a href="?idioma=pt" title="Português">
                <img src="webroot/images/banderaPortugal.svg" alt="Português">
            </a>

        </div>

    </header>

    <main>

        <!-- Formulario encargado de dirigir al usuario a la página de login. -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="submit" name="login" id="login"
                   value="<?php echo $textoBotonLogin; ?>">
        </form>

        <!-- Se muestra el esquema de navegación de la aplicación. -->
        <div class="arbol-navegacion">

            <img src="webroot/images/arbolNavegacion.PNG"
                 alt="Árbol de navegación de la aplicación Login Logoff">

        </div>
    </main>
    <footer>
        <p><a href="../YRMDWESProyectoDWES/indexProyectoDWES.php">Home</a></p>
        <div class="footer-text">
            <p>2026-27 IES Los Sauces. &copy; Todos los derechos reservados.
                <a href="../index.html">Yolanda Rodríguez Moreno</a></p>
            <time datetime="2026-11-18">Última actualización: 18 de noviembre de 2026</time>
        <a class="icono" href="https://github.com/YolandaRMA/YRMDWESLoginLogoffTema5" target="_blank">
            <img src="webroot/images/iconoGitHub.png" alt="">
        </a>
        </div>
    </footer>
</body>
</html>
