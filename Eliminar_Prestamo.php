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
require_once 'funciones/funciones_prestamos.inc.php';

/* * ********************************************************* */

//debo preguntar si la variable enviada por GET es valida: q sea un numero y mayor a cero
if (!empty($_GET['ID']) && is_numeric($_GET['ID']) && $_GET['ID'] > 0) {
    $IdPrestamoParaEliminar = $_GET['ID'];
    //si lo es, procedo a eliminar
    if (Eliminar_Prestamo($IdPrestamoParaEliminar) != false) {
        //si todo ok, el registro fue borrado --> redirecciono al listado de libros
        //manteniendo los mensajes en la SESSION
        $_SESSION['MensajeOk'] = "Prestamo eliminado correctamente!";
    } else {
        $_SESSION['MensajeError'] = "No se pudo eliminar el prestamo seleccionado. Intenta nuevamente.";
    }
    header('Location: Listado_Prestamos.php');
    exit;
}
?>