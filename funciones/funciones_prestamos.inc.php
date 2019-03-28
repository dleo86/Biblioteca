<?php

function Listar_Prestamos(){
    $Listado=array();
    $MiConexion=ConexionBD();
    if ($MiConexion!=false){
        //http://www.w3schools.com/sql/func_date_format.asp
        $SQL = "SELECT P.id AS IdPrestamo, S.nombre AS NombreSocio, S.apellido AS ApellidoSocio, 
                L.nombre AS NombreLibro, P.fecha_prestamo AS FechaPrestamo, P.fecha_devolucion AS FechaDev    
                FROM socios S, prestamo P, libros L
                WHERE P.id_socio=S.id AND P.id_libro=L.id 
                order by FechaPrestamo";
        $rs = mysqli_query($MiConexion, $SQL);
        $i=0;
        while ($data = mysqli_fetch_row($rs)) {
            $Listado[$i]['ID'] = $data[0];
            $Listado[$i]['NOMBRE_SOCIO'] = utf8_encode($data[1]).", ".utf8_encode($data[2]);
            $Listado[$i]['NOMBRE_LIBRO'] = $data[3];
            $Listado[$i]['FECHA_PRESTAMO'] = $data[4];
            $Listado[$i]['FECHA_DEVOLUCION'] = $data[5];
            $i++;
        }
    }

    return $Listado;

}

function ControlesValidos_prestamos($IdSocio){
    $MensajeError = '';
    //me conecto
    $linkConexion = ConexionBD();
    
    //la consulta debe traer un registro si ese mail ya fue cargado
    $SQL = "SELECT nombre, apellido FROM socios WHERE id = $IdSocio  ";
    $rs = mysqli_query($linkConexion, $SQL);
    
    $data = mysqli_fetch_array($rs);
    //si el conjunto de registros contiene valores, ese mail ya se registro
    if ($data != true) {
        $MensajeError = 'Este socio no ha sido registrado. <br />';
    }
   // echo "Entro a autor repetido";
    //devuelvo el mensaje, cargado o vacio segun encuentre o no ese mail
    return $MensajeError;
}

function ControlesValidos2($IdLibro){
    $MensajeError = '';
    //me conecto
    $linkConexion = ConexionBD();
    
    //la consulta debe traer un registro si ese mail ya fue cargado
    $SQL = "SELECT nombre FROM libros WHERE id = $IdLibro";
    $rs = mysqli_query($linkConexion, $SQL);
    
    $data = mysqli_fetch_array($rs);
    //si el conjunto de registros contiene valores, ese mail ya se registro
    if ($data != true) {
        $MensajeError = 'Este libro no pertenece al inventario. <br />';
    }
   // echo "Entro a autor repetido";
    //devuelvo el mensaje, cargado o vacio segun encuentre o no ese mail
    return $MensajeError;
}

function Insertar_Prestamo() {
    $SQL = "INSERT INTO prestamo(id_libro, id_socio, fecha_prestamo, fecha_devolucion) 
        VALUES ('{$_POST['IdLibro']}'  ,'{$_POST['IdSocio']}', now()  , adddate(now(),+7) )";

    $MiConexion = ConexionBD();
    if (!mysqli_query($MiConexion, $SQL)){
        return false;
    }else {
        return true;
    }
}

function Eliminar_Prestamo($Id) {
    $SQL = "DELETE FROM prestamo WHERE id=$Id";

    $MiConexion = ConexionBD();
    if (!mysqli_query($MiConexion, $SQL)) {
        return false;
    } else {
        return true;
    }
}
/*function ControlarAutorRepetido($Apellido) {
//esta funcion toma un parametro, llamado $Email
//le es brindado desde la llamada de la funcion en el script principal con el $_POST['Email']
    
    $MensajeError = '';
    
    //me conecto
    $linkConexion = ConexionBD();
    
    //la consulta debe traer un registro si ese mail ya fue cargado
    $SQL = "SELECT id FROM autores WHERE apellido = '{$Apellido}'  ";
    $rs = mysqli_query($linkConexion, $SQL);
    
    $data = mysqli_fetch_array($rs);
    //si el conjunto de registros contiene valores, ese mail ya se registro
    if ($data != false) {
        $MensajeError = 'Este autor ya ha sido registrado. <br />';
    }
   // echo "Entro a autor repetido";
    //devuelvo el mensaje, cargado o vacio segun encuentre o no ese mail
    return $MensajeError;
}

*/

?>