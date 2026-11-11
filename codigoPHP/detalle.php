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
                '_SESSION',
                '_COOKIE',
                '_SERVER',
                '_REQUEST',
                '_GET',
                '_POST',
                '_FILES',
                '_ENV'
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
            <p><a href="../indexProyectoTema5.php">Home</a></p>
            <div class="footer-text">
                <p>2026-27 IES Los Sauces. &copy; Todos los derechos reservados.<a href="../index.html">Yolanda Rodríguez Moreno</a></p>
                <time datetime="2026-09-30">Última actualización: 05 de Octubre de 2026</time>
            </div>
        </footer>
    </body>
</html>
