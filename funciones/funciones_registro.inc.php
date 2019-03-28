<?php

function ControlesValidos(){
    $MensajeError='';
    //voy concatenando los mensajes de error a medida q van saliendo
    $_POST['Nombre']=trim($_POST['Nombre']); //limpio espacios al Nombre
    if (strlen($_POST['Nombre'])<3){  //longitud de cada control.. 
        $MensajeError.='Debe ingresar su nombre <br />';
    }
    $_POST['Apellido']=trim($_POST['Apellido']); //limpio espacios al Apellido
    if (strlen($_POST['Apellido'])<3){ //longitud de cada control.. 
        $MensajeError.='Debe ingresar su apellido <br />';
    }
    
    $_POST['Usuario']=trim($_POST['Usuario']); //limpio espacios al Email
    if (strlen($_POST['Usuario'])<5){
        $MensajeError.='Debe ingresar un usuario correcto <br />';
    }

    $_POST['Email']=trim($_POST['Email']); //limpio espacios al Email
    if (strlen($_POST['Email'])<5){
        $MensajeError.='Debe ingresar un email correcto <br />';
    }

    $_POST['Clave']=trim($_POST['Clave']); //limpio espacios al Clave
    if (strlen($_POST['Clave'])<5){
        $MensajeError.='La clave debe contener al menos 5 caracteres. <br />';
    }
    $_POST['ReClave']=trim($_POST['ReClave']); //limpio espacios al ReClave
    if ($_POST['Clave']!=$_POST['ReClave']){  //si ambos valores de clave y reClave son distintos.. error.
        $MensajeError.='Las claves no coinciden. <br />';
    }
  //retorno la variable
    return $MensajeError;
}


function ControlarUsuarioRepetido($Usuario) {
//esta funcion toma un parametro, llamado $Email
//le es brindado desde la llamada de la funcion en el script principal con el $_POST['Email']
    
    $MensajeError = '';
    
    //me conecto
    $linkConexion = ConexionBD();
    
    //la consulta debe traer un registro si ese mail ya fue cargado
    $SQL = "SELECT id FROM socios WHERE usuario = '{$Usuario}'  ";
    //entre comillas simples porque es una cadena, q aqui llega como parametro de la funcion
    
    //me conecto
    $rs = mysqli_query($linkConexion, $SQL);
    
    $data = mysqli_fetch_array($rs);
    //si el conjunto de registros contiene valores, ese mail ya se registro
    if ($data != false) {
        $MensajeError = 'Este usuario ya ha sido registrado. <br />';
    }
    //devuelvo el mensaje, cargado o vacio segun encuentre o no ese mail
    return $MensajeError;
}


function Insertar(){
    
    //recordar las comillas simples en cada valor literal q va a la consulta
    $SQL="INSERT INTO socios (nombre, apellido, email, usuario, clave, fecha_registro)
          VALUES ('{$_POST['Nombre']}', '{$_POST['Apellido']}', '{$_POST['Email']}', '{$_POST['Usuario']}',
                     MD5('{$_POST['Clave']}') , now() )" ;
             
    $linkConexion=ConexionBD();
    if (!mysqli_query($linkConexion, $SQL)){
        return false;
    }else {
        return true;
    }
}
?>
