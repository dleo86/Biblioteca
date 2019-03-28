<?php

function Listar_Socios(){
    $Listado=array();
    $MiConexion=ConexionBD();
    if ($MiConexion!=false){
        //http://www.w3schools.com/sql/func_date_format.asp
        $SQL = "SELECT id, nombre, apellido, email, usuario, 
                DATE_FORMAT(fecha_registro,'%d/%m/%Y %H:%i:%s')  
                FROM socios order by apellido, nombre";
        $rs = mysqli_query($MiConexion, $SQL);
        $i=0;
        while ($data = mysqli_fetch_row($rs)) {
            $Listado[$i]['ID'] = $data[0];
            $Listado[$i]['NOMBRE_SOCIO'] = utf8_encode($data[1]).", ".utf8_encode($data[2]);
            $Listado[$i]['EMAIL'] = $data[3];
            $Listado[$i]['USUARIO'] = $data[4];
            $Listado[$i]['FECHA_REGISTRACION'] = $data[5];
            $i++;
        }
    }

    return $Listado;

}




?>
