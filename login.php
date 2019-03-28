<?php
session_start();
require_once 'funciones/funciones_conexion.inc.php';
require_once 'funciones/funciones_login.inc.php';


if (!empty($_POST['btnLogin'])) {
    $_SESSION['Mensaje'] = ControlesValidosLogin();
   // echo "Hola mundo";
    //si la funcion devuelve los mensajes, los mostrare mas abajo
    //si la funcion devuelve un mensaje vacio, entonces ya puedo loguear
    if (empty($_SESSION['Mensaje'])) {
        $DatosUsuario = DatosUsuarioCorrecto($_POST['Login'], md5($_POST['Clave']));
        if ($DatosUsuario != false) {
            //cargo la variable de Sesion con los datos del usuario
            $_SESSION['USUARIO_ID'] = $DatosUsuario['ID'];
            $_SESSION['USUARIO_NOMBRE'] = $DatosUsuario['NOMBRE_SOCIO'];
            $_SESSION['USUARIO_EMAIL'] = $DatosUsuario['EMAIL'];
            $_SESSION['USUARIO_NIVEL'] = $DatosUsuario['NIVEL'];
            //habilito el panel redireccionando al index
            header('Location: index.php');
            exit;
            
        } else {
            $_SESSION['Mensaje'] = 'Usuario y clave incorrectos.';
        }
    }
}

//requiero el encabezado
require_once 'includes/header.inc.php';
?>
    <body>
        <div>
            <?php
            if (!empty($_SESSION['Mensaje'])) {
                echo $_SESSION['Mensaje'];
            }
            ?>
            <form method="post">
                <h2>
                    Login de usuario
                </h2>
                Login
                <input type="text" name="Login" value="<?php echo!empty($_POST['Login']) ? $_POST['Login'] : ''; ?>" />
                <br />
                Clave:
                <input type="password" name="Clave" value="" />
                <br />
                <input type="submit" name="btnLogin" value="Login" />
            </form>

            <hr />
            Si no tienes cuenta, <a href="registro.php">Registrate aqui! </a>
        </div>            
    </body>
</html>
<?php 
//destruyo aqui directamente toda variable de sesion mientras no se encuentre logueado
session_destroy();
$_SESSION = array(); ?>