<?php
session_start();
//requiero la funcion de conexion
//noten que ahora he separado mas las funciones, dejando la conexion sola
//y agrupando por distintos archivos cada modulo q voy trabajando
require_once 'funciones/funciones_conexion.inc.php';
//y luego las funciones que se utilizan para el registro
require_once 'funciones/funciones_registro.inc.php';

//si pulsa el boton comienzo validando los controles
if (!empty($_POST['btnEnviar'])) {
    $_SESSION['Mensaje'] = ControlesValidos();
   
    //esta funcion devolvera un mensaje si el mail ya fue registrado
    //este mensaje se concatena al mensaje anterior
    $_SESSION['Mensaje'].= ControlarUsuarioRepetido($_POST['Usuario']);
    
    //si la funcion devuelve los mensajes, los mostrare mas abajo
    //si la funcion devuelve un mensaje vacio, entonces ya puedo registrar
    if (empty($_SESSION['Mensaje'])) {
        if (Insertar() != false) {
            $_SESSION['Mensaje'] = 'Registro almacenado!!';
            header('Location: registro.php');
            exit;
        } else {
            $_SESSION['Mensaje'] = 'Error al intentar almacenar.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Mysql</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>
<?php
if (!empty($_SESSION['Mensaje'])) {
    echo $_SESSION['Mensaje'];
}
?>
            <form method="post">
                <h2>
                    Registro de usuario
                </h2>
                <h4>
                    * Todos los datos son requeridos<br />
                    * la clave debe coincidir con el nuevo ingreso de clave<br />
                    * Se deben mantener los 3 primeros campos mientras haya error
                </h4>  
                Nombre:
                <input type="text" name="Nombre" value="<?php echo!empty($_POST['Nombre']) ? $_POST['Nombre'] : ''; ?>" />
                <br />
                Apellido:
                <input type="text" name="Apellido" value="<?php echo!empty($_POST['Apellido']) ? $_POST['Apellido'] : ''; ?>" />
                <br />
                Email
                <input type="email" name="Email" value="<?php echo!empty($_POST['Email']) ? $_POST['Email'] : ''; ?>" />
                <br />
                Usuario:
                <input type="text" name="Usuario" value="<?php echo!empty($_POST['Usuario']) ? $_POST['Usuario'] : ''; ?>" />
                <br />
                Clave:
                <input type="password" name="Clave" value="" />
                <br />
                Ingrese nuevamente su Clave:
                <input type="password" name="ReClave" value="" />
                <br />
                <input type="submit" name="btnEnviar" value="Enviar" />
            </form>

        </div>            

        <hr />
        Ya tienes cuenta? Ingresa <a href="login.php">aqui</a>

    </body>
</html>
<?php session_destroy();
$_SESSION = array(); ?>