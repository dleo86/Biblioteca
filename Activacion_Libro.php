<?php

session_start();
//si la variable de sesion esta vacia, no debe poder entrar al panel
//redirecciono al logueo
if (empty($_SESSION['USUARIO_ID'])) {
    header('Location: login.php');
    exit;
}
//incluyo el script con la funcion de conexion
require_once 'funciones/funciones_conexion.inc.php';
//y las funciones referidas a los libros
require_once 'funciones/funciones_libros.inc.php';

/* * ********************************************************* */

//debo preguntar por las variables enviadas por GET q sean validas
//aseguro q el IdLibro sea numerico mayor a cero y q la Accion llegue con valor
if (!empty($_GET['IdLibro']) && is_numeric($_GET['IdLibro']) && $_GET['IdLibro'] > 0
        && !empty($_GET['Accion'])) {


    $IdLibroModificar = $_GET['IdLibro'];

    //aseguro q el valor de la Accion sea uno de estos dos: No disponible o Disponible
    if ($_GET['Accion'] == 'No disponible') {

        $Disponible = 0;
        //actualizo desactivando el libro
        if (Activacion_Libro($Disponible, $IdLibroModificar) != false) {
            $_SESSION['MensajeOk'] = "Libro desactivado correctamente!";
        } else {
            $_SESSION['MensajeError'] = "El libro no se pudo desactivar. Intenta nuevamente..";
        }
        
    } elseif ($_GET['Accion'] == 'Disponible') {

        $Disponible = 1;
        //actualizo activando el libro
        if (Activacion_Libro($Disponible, $IdLibroModificar) != false) {
            $_SESSION['MensajeOk'] = "Libro activado correctamente!";
        } else {
            $_SESSION['MensajeError'] = "El libro no se pudo activar. Intenta nuevamente..";
        }
        
    } else {
        $_SESSION['MensajeError'] = "Operaci&oacute;n incorrecta.";
    }
    
} else {
    //falla algun parametro
    $_SESSION['MensajeError'] = "Par&aacute;metros incorrectos para realizar esta funcionalidad.";
}

//sea el mensaje q fuere, debo volver al listado informando tal situacion
header('Location: Listado_Libros_Imagen_Operaciones.php');
exit;
?>
