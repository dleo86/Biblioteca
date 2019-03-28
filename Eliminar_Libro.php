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

//debo preguntar si la variable enviada por GET es valida: q sea un numero y mayor a cero
if (!empty($_GET['IdLibro']) && is_numeric($_GET['IdLibro']) && $_GET['IdLibro'] > 0) {
    $IdLibroParaEliminar = $_GET['IdLibro'];
    //si lo es, procedo a eliminar
    if (Eliminar_Libro($IdLibroParaEliminar) != false) {
        //si todo ok, el registro fue borrado --> redirecciono al listado de libros
        //manteniendo los mensajes en la SESSION
        $_SESSION['MensajeOk'] = "Libro eliminado correctamente!";
    } else {
        $_SESSION['MensajeError'] = "No se pudo eliminar el libro seleccionado. Intenta nuevamente.";
    }
    header('Location: Listado_Libros_Imagen_Operaciones.php');
    exit;
}
?>
