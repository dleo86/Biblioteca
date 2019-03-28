<?php
function ConexionBD() {
    //parametros de conexion
    $Host = 'localhost';    //tambien podemos usar el IP: 127.0.0.1
    $User = 'root';         //el usuario de acceso a la BD
    $Password = '';         //la clave por defecto es vacio
    $BaseDeDatos = 'biblioteca';  //la BD q creamos

//procedo al intento de conexion con esos parametros
    $linkConexion = mysqli_connect($Host, $User, $Password, $BaseDeDatos);
    //nos devolvera false en caso de no poder hacerlo, 
    //sino el link de conexion
    return $linkConexion;
}

//la separo para usarla sola.
//luego por cada modulo, voy agregando las funciones especificas.

?>
