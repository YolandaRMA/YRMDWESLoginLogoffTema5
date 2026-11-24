
<?php
/**
 * @author: Yolanda Rodríguez Moreno
 * @since: 18/11/2026
 * Proyecto Login Logoff Tema 5.
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

// Función recursiva para mostrar los datos de las superglobales.
// Las claves se muestran en negrita y los valores en letra normal.
// Si un valor contiene otro array, se vuelve a recorrer.
function mostrarContenido($contenido) {

    if (is_array($contenido)) {

        echo "<ul>";

        foreach ($contenido as $clave => $valor) {

            echo "<li>";

            // Se muestra el nombre de la clave en negrita.
            echo "<strong>" . htmlspecialchars((string) $clave) . ":</strong> ";

            if (is_array($valor)) {

                // Si el valor es otro array, se muestran sus elementos.
                mostrarContenido($valor);

            } elseif (is_bool($valor)) {

                // Se muestran los valores booleanos como texto.
                echo $valor ? "true" : "false";

            } elseif ($valor === null) {

                // Se indica cuando el valor es NULL.
                echo "NULL";

            } else {

                // Se muestra el contenido del valor.
                echo htmlspecialchars((string) $valor);
            }

            echo "</li>";
        }

        echo "</ul>";

    } else {

        echo htmlspecialchars((string) $contenido);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../webroot/css/estilos.css">
    <title>Variables superglobales</title>
</head>

<body>

    <header>
        <h2>Mostrar el contenido de las variables superglobales y phpinfo()</h2>
    </header>

    <main>
        <?php
        // Array para respetar el orden requerido para mostrar las superglobales.
        // Se guarda el nombre de cada superglobal junto con su contenido.
        $aOrdenSuperglobales = [
            '_SESSION' => $_SESSION,
            '_COOKIE'  => $_COOKIE,
            '_SERVER'  => $_SERVER,
            '_REQUEST' => $_REQUEST,
            '_GET'     => $_GET,
            '_POST'    => $_POST,
            '_FILES'   => $_FILES,
            '_ENV'     => $_ENV
        ];

        // Se recorren las superglobales siguiendo el orden establecido.
        // $nombre contiene el nombre y $contenido almacena sus datos.
        foreach ($aOrdenSuperglobales as $nombre => $contenido) {

            echo "<h3>Contenido de \$" . $nombre . "</h3>";

            // Se comprueba si la superglobal contiene información.
            if (empty($contenido)) {

                echo "<p>Sin contenido disponible.</p>";

            } else {

                // Se llama a la función para mostrar las claves en negrita
                // y los valores de cada elemento en letra normal.
                mostrarContenido($contenido);
            }

            echo "<hr>";
        }

        // Se muestra la información de configuración de PHP.
        phpinfo();
        ?>
    </main>

    <footer>
        <p><a href="../../YRMDWESProyectoDWES/indexProyectoDWES.php">Home</a></p>

        <div class="footer-text">
            <p>2026-27 IES Los Sauces. &copy; Todos los derechos reservados.
                <a href="../../index.html">Yolanda Rodríguez Moreno</a>
            </p>

            <time datetime="2026-11-23">Última actualización: 23 de Noviembre de 2026</time>

            <a class="icono" href="https://github.com/YolandaRMA/YRMDWESLoginLogoffTema5" target="_blank">
                <img src="../webroot/images/iconoGitHub.png" alt="">
            </a>
        </div>
    </footer>

</body>
</html>
