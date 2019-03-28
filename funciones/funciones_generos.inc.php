<?php
function Insertar_genero(){
    $SQL="INSERT INTO generos (nombre)
        VALUES ('{$_POST['Nombre']}')";
             
    $linkConexion=ConexionBD();
    //$MensajeError='';
    if (!mysqli_query($linkConexion, $SQL)){
        return false;
    }else {
        echo "entro a la conexion";
        return true;
    }
}

function ControlesValidos_generos(){
    $MensajeError='';
    //voy concatenando los mensajes de error a medida q van saliendo
    $_POST['Nombre']=trim($_POST['Nombre']); //limpio espacios al Nombre
    if (strlen($_POST['Nombre'])<3){
        $MensajeError.='Debe ingresar el nombre <br />';
    }
    
    return $MensajeError;
}

function ControlarGeneroRepetido($Nombre) {
//esta funcion toma un parametro, llamado $Email
//le es brindado desde la llamada de la funcion en el script principal con el $_POST['Email']
    
    $MensajeError = '';
    
    //me conecto
    $linkConexion = ConexionBD();
    
    //la consulta debe traer un registro si ese mail ya fue cargado
    $SQL = "SELECT id FROM generos WHERE nombre = '{$Nombre}'  ";
    $rs = mysqli_query($linkConexion, $SQL);
    
    $data = mysqli_fetch_array($rs);
    //si el conjunto de registros contiene valores, ese mail ya se registro
    if ($data != false) {
        $MensajeError = 'Este genero ya ha sido registrado. <br />';
    }
   // echo "Entro a autor repetido";
    //devuelvo el mensaje, cargado o vacio segun encuentre o no ese mail
    return $MensajeError;
}
?>