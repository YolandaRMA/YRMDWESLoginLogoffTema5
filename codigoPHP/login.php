
<?php
/**
 * @author: Yolanda Rodríguez Moreno
 * @since: 11/11/2026
 * Proyecto Login Logoff Tema 5.
 */

// Se comprueba si se ha pulsado el botón Cancelar.
// Si se ha pulsado, se redirige al usuario al index público del proyecto.
if (isset($_POST['cancelar'])) {
    header("Location: ../indexProyectoLoginLogoffTema5.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sesion iniciada</title>
        <link rel="stylesheet" href="../webroot/css/estilos.css">
    </head>

    <body>

        <header>
            <div class="cabecera-logo">
                <img src="../webroot/images/logoCandado.jpg" alt="Logo Login Logoff">
            </div>

            <div class="cabecera-titulos">
                <h1>Tema 5. Aplicación Login Logoff</h1>
                <h3>Sesión Iniciada</h3>
            </div>
        </header>

        <main>

            

            <!-- Formulario encargado de regresar al inicio público. -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                <input type="submit" name="cancelar" id="cancelar" value="Cancelar">

            </form>

        </main>

        <footer>

            <p>
                <a href="../../YRMDWESProyectoDWES/indexProyectoDWES.php">Home</a>
            </p>

            <div class="footer-text">

                <p>
                    2026-27 IES Los Sauces. &copy; Todos los derechos reservados.
                    <a href="../../index.html">Yolanda Rodríguez Moreno</a>
                </p>

                <time datetime="2026-11-11">
                    Última actualización: 11 de noviembre de 2026
                </time>

            </div>

        </footer>

    </body>
</html>
