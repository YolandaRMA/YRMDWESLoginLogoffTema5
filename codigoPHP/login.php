
<?php
/**
 * @author: Yolanda Rodríguez Moreno
 * @since: 12/11/2026
 * Proyecto Login Logoff Tema 5.
 */

// Se comprueba si se ha pulsado el botón Cancelar.
// Si se ha pulsado, se vuelve a la página de inicio pública.
if (isset($_POST['cancelar'])) {
    header("Location: ../indexProyectoLoginLogoffTema5.php");
    exit();
}

// Se incluye el archivo que contiene los datos de conexión
// necesarios para establecer la conexión con la base de datos mediante PDO.
require_once '../config/configDB00.php';

// Se incluye la librería que contiene los métodos
// utilizados para validar los datos introducidos en el formulario.
require_once '../core/231018libreriaValidacion.php';

// Se inicializa la variable que indica si los datos del formulario son válidos.
$entradaOK = true;

// Se inicializa la variable que indica si se han encontrado las credenciales.
$usuarioEncontrado = true;

// Se inicializa la variable que almacenará los posibles errores de conexión.
$errorConexion = "";

// Se crea un array asociativo para guardar los mensajes de error
// correspondientes a cada uno de los campos del formulario.
$aError = [
    'usuario' => "",
    'contrasena' => ""
];

// Se inicializa la variable que almacenará el código de usuario introducido.
// Así se puede conservar su contenido si se produce algún error.
$usuarioIntroducido = "";

// Se comprueba si se ha enviado el formulario pulsando el botón Entrar.
if (isset($_POST['login'])) {

    // Se recoge el código de usuario y se eliminan los espacios
    // en blanco que pueda tener al principio o al final.
    $usuarioIntroducido = trim($_POST['usuario']);

    // Se comprueba que el código de usuario sea alfanumérico,
    // tenga entre 4 y 8 caracteres y sea obligatorio.
    // Estos límites coinciden con la restricción definida en la tabla T01_Usuario.
    $aError['usuario'] = validacionFormularios::comprobarAlfaNumerico(
        $usuarioIntroducido,
        8,
        4,
        1
    );

    // Se comprueba que la contraseña sea alfanumérica,
    // tenga como máximo 1000 caracteres y sea obligatoria.
    $aError['contrasena'] = validacionFormularios::comprobarAlfaNumerico(
        $_POST['contrasena'],
        1000,
        1,
        1
    );

    // Se recorren los mensajes de error del formulario.
    // Si alguno contiene un mensaje, los datos no son válidos.
    foreach ($aError as $mensajeError) {
        if (!empty($mensajeError)) {
            $entradaOK = false;
        }
    }

} else {

    // Si todavía no se ha enviado el formulario,
    // no se realiza ninguna consulta a la base de datos.
    $entradaOK = false;
}

// Se inicializa la variable de conexión.
$miDB = null;

// Solamente se accede a la base de datos si los datos
// introducidos en el formulario han superado las validaciones.
if ($entradaOK) {

    try {

        // Se establece la conexión con la base de datos mediante PDO.
        // HOST contiene la cadena DSN completa y USER y PASS
        // contienen las credenciales definidas en el archivo de configuración.
        $miDB = new PDO(HOST, USER, PASS);

        // Se prepara una consulta para comprobar si existe un usuario
        // cuyo código y contraseña coincidan con los datos introducidos.
        // SHA2 calcula el hash de la combinación del código de usuario
        // y la contraseña, igual que se hizo al insertar los usuarios.
        $sqlConsultaUsuario = <<<SQL
            SELECT T01_CodUsuario
            FROM T01_Usuario
            WHERE T01_CodUsuario = :codigoUsuario
            AND T01_Password = SHA2(CONCAT(:codigoUsuarioHash, :contrasena), 256)
        SQL;

        // Se prepara la consulta SQL antes de ejecutarla.
        // Los parámetros permiten incorporar los datos del formulario
        // sin concatenarlos directamente en la sentencia SQL.
        $consultaUsuario = $miDB->prepare($sqlConsultaUsuario);

        // Se ejecuta la consulta sustituyendo cada parámetro por su valor.
        // Se utiliza el código de usuario junto con la contraseña
        // para calcular el mismo hash que está almacenado en la base de datos.
        $consultaUsuario->execute([
            ':codigoUsuario' => $usuarioIntroducido,
            ':codigoUsuarioHash' => $usuarioIntroducido,
            ':contrasena' => trim($_POST['contrasena'])
        ]);

        // Se obtiene el registro que cumple las condiciones de la consulta.
        // fetch() devuelve los datos encontrados o false si no existe ningún registro.
        $registroUsuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);

        // Se comprueba si se ha encontrado un usuario con esas credenciales.
        if ($registroUsuario) {

            // Si las credenciales son correctas, se redirige al usuario
            // a la página de acceso privado de la aplicación.
            // exit() detiene la ejecución después de realizar la redirección.
            header("Location: Programa.php");
            exit();

        } else {

            // Si no se encuentra ningún registro, se indica que las
            // credenciales introducidas no son correctas.
            $usuarioEncontrado = false;
        }

    } catch (PDOException $miExcepcionPDO) {

        // Si se produce un error durante la conexión o la consulta,
        // se guarda el mensaje de la excepción para mostrarlo en la página.
        $errorConexion = "Error en la base de datos: " . $miExcepcionPDO->getMessage();

    } finally {

        // Se libera la conexión con la base de datos al finalizar la operación.
        unset($miDB);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="../webroot/css/estilos.css">
</head>

<body>

    <header>
        <div class="cabecera-logo">
            <img src="../webroot/images/logoCandado.jpg" alt="Logo Login Logoff">
        </div>

        <div class="cabecera-titulos">
            <h1>Inicio de sesión</h1>
        </div>
    </header>

    <main>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

            <div class="campo">

                <label for="usuario">Usuario:</label>

                <input
                    type="text"
                    name="usuario"
                    id="usuario"
                    value="<?php echo $usuarioIntroducido; ?>"
                >

                <?php
                // Se muestra el mensaje de validación del usuario
                // solamente cuando se ha producido algún error.
                if (!empty($aError['usuario'])) {
                    echo "<p class='error'>" . $aError['usuario'] . "</p>";
                }
                ?>

            </div>

            <div class="campo">

                <label for="contrasena">Contraseña:</label>

                <input
                    type="password"
                    name="contrasena"
                    id="contrasena"
                >

                <?php
                // Se muestra el mensaje de validación de la contraseña
                // solamente cuando se ha producido algún error.
                if (!empty($aError['contrasena'])) {
                    echo "<p class='error'>" . $aError['contrasena'] . "</p>";
                }
                ?>

            </div>

            <input type="submit" name="cancelar" id="cancelar" value="Cancelar">
            <input type="submit" name="login" id="login" value="Entrar">

            <?php
            // Si no se ha encontrado el usuario en la base de datos,
            // se muestra un mensaje indicando que las credenciales son incorrectas.
            if (!$usuarioEncontrado) {
                echo "<p class='error'>Usuario o contraseña incorrectos.</p>";
            }

            // Si se ha producido un error de conexión o de consulta,
            // se muestra el mensaje correspondiente.
            if (!empty($errorConexion)) {
                echo "<p class='error'>" . $errorConexion . "</p>";
            }
            ?>

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

            <time datetime="2026-11-12">
                Última actualización: 12 de noviembre de 2026
            </time>
        </div>

    </footer>

</body>
</html>
