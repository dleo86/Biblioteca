<?php
session_start();
//incluyo el script con la funcion de conexion
require_once 'funciones/funciones_conexion.inc.php';
//incluyo el script con las funciones referidas a los Libros
require_once 'funciones/funciones_autores.inc.php';

//incluyo el script con el encabezado del archivo principal
require_once 'includes/header.inc.php';

//si pulsa el boton comienzo validando los controles
if (!empty($_POST['btnEnviar'])) {
    $_SESSION['Mensaje'] = ControlesValidos_autores();
    
    //esta funcion devolvera un mensaje si el mail ya fue registrado
    //este mensaje se concatena al mensaje anterior
    $_SESSION['Mensaje'].= ControlarAutorRepetido($_POST['Apellido']); 
    
    //si la funcion devuelve los mensajes, los mostrare mas abajo
    //si la funcion devuelve un mensaje vacio, entonces ya puedo registrar
    if (empty($_SESSION['Mensaje'])) {
        if (Insertar_autor() != false) {
            //echo "entro 1";
            $_SESSION['Mensaje'] = 'Registro almacenado!!';
            header('Location: Cargar_autor.php');
            exit;
        } else {
            //echo "entro 2";
            $_SESSION['Mensaje'] = 'Error al intentar almacenar.';
        }
    }
}
?>
<body>
    
    <div>

        <?php require_once 'includes/user.inc.php'; ?>
        <hr />

        <?php require_once 'includes/menu.inc.php'; ?>
        <hr />
    </div>   
    
<?php
if (!empty($_SESSION['Mensaje'])) {
    echo $_SESSION['Mensaje'];
}
?>
            <form method="post">
                <h2>
                    Registro de Autores
                </h2>
                <h4>
                    * Todos los datos son requeridos<br />
                    
                    
                </h4>  
                Nombre:
                <input type="text" name="Nombre" value="<?php echo!empty($_POST['Nombre']) ? $_POST['Nombre'] : ''; ?>" />
                <br />
                Apellido:
                <input type="text" name="Apellido" value="<?php echo!empty($_POST['Apellido']) ? $_POST['Apellido'] : ''; ?>" />
                <br />
               
                <input type="submit" name="btnEnviar" value="Enviar" />
            </form>

        </div>            

        <a href="Listado_Socios.php">Ver el listado de socios registrados</a>

    </body>
<?php
require_once 'includes/pie.inc.php';
//aqui no debo cerrar sesiones en el pie, sino me volvera a pedir el login
//la sesion se debe cerrar solo del link de Cerrar Sesion.
?>