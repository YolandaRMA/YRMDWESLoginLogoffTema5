
<?php
/**
 * @author: Yolanda Rodríguez Moreno
 * @since: 16/11/2026
 * Proyecto Login Logoff Tema 5.
 *
 * Esta página permite iniciar sesión en la aplicación.
 * Comprueba los datos introducidos, verifica el usuario y la contraseña
 * en la base de datos y si son correctos guarda sus datos en la sesión
 * para acceder a la parte privada de la aplicación.
 */

// Se inicia la sesión para poder guardar los datos del usuario
// que ha iniciado sesión y utilizarlos en las páginas privadas.
session_start();

// Se comprueba si se ha pulsado el botón Cancelar.
// Si se ha pulsado, se vuelve a la página de inicio pública.
if (isset($_POST['cancelar'])) {
    header("Location: ../indexProyectoLoginLogoffTema5.php");
    exit();
}

// Se recupera el idioma almacenado en la cookie cookieIdioma.
// Si todavía no existe, se establece español por defecto.
$idioma = $_COOKIE['cookieIdioma'] ?? 'es';

// Se incluye el archivo que contiene los datos de conexión
// necesarios para establecer la conexión con la base de datos mediante PDO.
require_once '../config/configDB00.php';

// Se incluye la librería que contiene los métodos utilizados para validar los datos introducidos en el formulario.
require_once '../core/231018libreriaValidacion.php';

// Se inicializa la variable que indica si los datos del formulario son válidos
$entradaOK = true;

// Se inicializa la variable que indica si se han encontrado las credenciales
$usuarioEncontrado = true;

// Se inicializa la variable que almacenará los posibles errores de conexión.
$errorConexion = "";

// Se crea un array asociativo para guardar los mensajes de error
// correspondientes a cada uno de los campos del formulario
$aError = [
    'usuario' => "",
    'contrasena' => ""
];

// Se inicializa la variable que almacenará el código de usuario introducido.
// Así se puede conservar su contenido si se produce algún error.
$usuarioIntroducido = "";

// Se inicializa la variable de conexión.
$miDB = null;

// Se comprueba si se ha enviado el formulario pulsando el botón Entrar
if (isset($_POST['login'])) {

    // Se recoge el código de usuario, elimina espacios en blanco y convierte a minúsculas
    $usuarioIntroducido = strtolower(trim($_POST['usuario']));

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
            SELECT *
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
        // fetch() devuelve un array asociativo con los datos del usuario
        // o false si no existe ningún registro que coincida.
        $registroUsuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);

        // Se comprueba si se ha encontrado un usuario con esas credenciales.
        if ($registroUsuario) {

            // Se guarda la fecha de la última conexión anterior antes de actualizarla,
            // para poder mostrarla después en la página privada.
            $fechaHoraUltimaConexion = $registroUsuario['T01_FechaHoraUltimaConexion'];

            // Se guarda la fecha y hora de la conexión que se está realizando ahora.
            $fechaHoraConexionActual = date('Y-m-d H:i:s');

            // Se prepara una consulta para incrementar el número de conexiones
            // y actualizar la fecha y hora de la última conexión del usuario.
            $sqlActualizarUsuario = <<<SQL
                UPDATE T01_Usuario
                SET T01_NumConexiones = T01_NumConexiones + 1,
                    T01_FechaHoraUltimaConexion = :fechaHoraConexionActual
                WHERE T01_CodUsuario = :codigoUsuario
            SQL;

            // Se prepara la consulta de actualización.
            $actualizarUsuario = $miDB->prepare($sqlActualizarUsuario);

            // Se ejecuta la actualización indicando el código del usuario
            // y la fecha y hora de la conexión actual.
            $actualizarUsuario->execute([
                ':codigoUsuario' => $usuarioIntroducido,
                ':fechaHoraConexionActual' => $fechaHoraConexionActual
            ]);

            // Se actualizan los datos del registro recuperado para que
            // la sesión contenga también el número y la fecha de conexión nuevos.
            $registroUsuario['T01_NumConexiones']++;

            // Se guarda la fecha y hora de la conexión actual en el registro del usuario.
            $registroUsuario['T01_FechaHoraUltimaConexion'] = $fechaHoraConexionActual;

            // Se elimina el hash de la contraseña antes de guardar los datos
            // del usuario en la sesión, ya que no es necesario conservarlo.
            unset($registroUsuario['T01_Password']);

            // Se guardan los datos del usuario en una variable de sesión.
            // $_SESSION permite conservar esta información entre páginas
            // mientras la sesión permanezca activa.
            $_SESSION['userYRMDWESLoginLogoffTema5'] = $registroUsuario;

            // Se guarda también la fecha de la conexión anterior en la sesión,
            // porque la fecha de la base de datos ya se ha actualizado.
            $_SESSION['fechaHoraUltimaConexion'] = $fechaHoraUltimaConexion;

            // Se cierra la conexión con la base de datos.
            unset($miDB);

            // Si las credenciales son correctas, se redirige al usuario
            // a la página de acceso privado de la aplicación.
            header("Location: inicioPrivado.php");
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

// Se preparan los textos del formulario según el idioma guardado en la cookie.
if ($idioma === 'pt') {

    $tituloPagina = "Início de sessão";
    $textoUsuario = "Utilizador:";
    $textoContrasena = "Palavra-passe:";
    $textoCancelar = "Cancelar";
    $textoEntrar = "Entrar";
    $textoErrorCredenciales = "Utilizador ou palavra-passe incorretos.";
    $textoErrorConexion = "Erro na base de dados:";

} else {

    $tituloPagina = "Inicio de sesión";
    $textoUsuario = "Usuario:";
    $textoContrasena = "Contraseña:";
    $textoCancelar = "Cancelar";
    $textoEntrar = "Entrar";
    $textoErrorCredenciales = "Usuario o contraseña incorrectos.";
    $textoErrorConexion = "Error en la base de datos:";
}
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

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

            <div class="campo">

                <label for="usuario"><?php echo $textoUsuario; ?></label>

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

                <label for="contrasena"><?php echo $textoContrasena; ?></label>

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

            <input type="submit" name="cancelar" id="cancelar"
                   value="<?php echo $textoCancelar; ?>">

            <input type="submit" name="login" id="login"
                   value="<?php echo $textoEntrar; ?>">

            <?php
            // Si no se ha encontrado el usuario en la base de datos,
            // se muestra un mensaje indicando que las credenciales son incorrectas.
            if (!$usuarioEncontrado) {
                echo "<p class='error'>" . $textoErrorCredenciales . "</p>";
            }

            // Si se ha producido un error de conexión o de consulta,
            // se muestra el mensaje correspondiente.
            if (!empty($errorConexion)) {
                echo "<p class='error'>" . $textoErrorConexion . " "
                    . $errorConexion . "</p>";
            }
            ?>

        </form>

    </main>

    <footer>
        <p><a href="../../YRMDWESProyectoDWES/indexProyectoDWES.php">Home</a></p>
        <div class="footer-text">
            <p>2026-27 IES Los Sauces. &copy; Todos los derechos reservados.
                <a href="../../index.html">Yolanda Rodríguez Moreno</a></p>
            <time datetime="2026-11-18">Última actualización: 18 de Noviembre de 2026</time>
        </div>
    </footer>

</body>
</html>
