<?php
/**
 * @author: Yolanda Rodríguez Moreno
 * @since: 11/11/2026
 * Proyecto Login Logoff Tema 5.
 */

// Se comprueba si se ha pulsado el botón para acceder al login.
// Si se ha pulsado, se redirige al usuario a la página login.php.
    if (isset($_POST['login'])) {
        header("Location: codigoPHP/login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inicio publico</title>
        <link rel="stylesheet" href="webroot/css/estilos.css">
     <body>

        <header>
            <div class="cabecera-logo">
                <img src="webroot/images/logoCandado.jpg" alt="Logo Login Logoff">
            </div>

            <div class="cabecera-titulos">
                <h1>Tema 5. Aplicación Login Logoff</h1>
                <h3>Inicio público</h3>
            </div>
        </header>

        <main>

            <!-- Formulario encargado de dirigir al usuario a la página de login. -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="submit" name="login" id="login" value="Iniciar sesión">
            </form>

        </main>
        <footer>
            <p><a href="../YRMDWESProyectoDWES/indexProyectoDWES.php">Home</a></p>
            <div class="footer-text">
                <p>2026-27 IES Los Sauces. &copy; Todos los derechos reservados.<a href="../index.html">Yolanda Rodríguez Moreno</a></p>
                <time datetime="2026-11-11">Última actualización: 11 de Octubre de 2026</time>
            </div>
        </footer>
    </body>
</html>
