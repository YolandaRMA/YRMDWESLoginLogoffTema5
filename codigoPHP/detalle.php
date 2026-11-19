<?php
    session_start();
    // Si usuario no logueado, re-direcciona al index. 
        if (!isset($_SESSION['usuarioMDCDWESAppLoginLogoff'])) {
            header("Location: login.php");
            exit;
        }

        // peticion de phpinfo antes de cargar el HTML
        if (isset($_GET['ver_phpinfo'])) {
            phpinfo();
            exit;
        }
 ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../webroot/css/estilos.css">
        <title>Variables superglobales</title>
    </head>
    <body>
        <header>
            <h2>Mostrar el contenido de las variables superglobales y phpinfo()</h2>
            <?php
//            session_start();
//            ?>
        </header>
        <main>
            <?php
            // array para respetar el orden requerido para mostrar las superglobales
            $aOrdenSuperglobales = [
               '$_SESSION' => $_SESSION,
                    '$_COOKIE'  => $_COOKIE,
                    '$_SERVER'  => $_SERVER,
                    '$_REQUEST' => $_REQUEST,
                    '$_GET'     => $_GET,
                    '$_POST'    => $_POST,
                    '$_FILES'   => $_FILES,
                    '$_ENV'     => $_ENV
            ];

            // se recorren las superglobales siguiendo el orden establecido
            foreach ($aOrdenSuperglobales as $nombre) {

                echo "<h3>Contenido de \$$nombre</h3>";

                // Comprobamos si la superglobal contiene información
                if (empty($GLOBALS[$nombre])) {
                    echo "<p>Sin contenido disponible.</p>";
                } else {
                    // <pre> para conservar los espacios y saltos de línea del contenido
                    echo "<pre>";
                    print_r($GLOBALS[$nombre]);
                    echo "</pre>";
                }

                echo "<hr>";
            }

            //se muestra la información de configuración de PHP
            phpinfo();
            ?>
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
