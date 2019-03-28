<?php

function Ver_Mis_Datos() {
    //consulto por el ID de registro que tiene mi sesion, al loguearme la genere.
    $SQL = "SELECT nombre, apellido, usuario, clave FROM socios WHERE id={$_SESSION['USUARIO_ID']}";
    //genero la conexion
    $linkConexion = ConexionBD();
    $rs = mysqli_query($linkConexion, $SQL);
    //por ser un solo registro el q debo traer, no aplico while
    $data = mysqli_fetch_array($rs);
    //si $data trajo algo, entonces cargo mis valores
    if ($data != false) {
        $DatosUsuario['NOMBRE'] = utf8_encode($data['nombre']);
        $DatosUsuario['APELLIDO'] = utf8_encode($data['apellido']);
        $DatosUsuario['USUARIO'] = utf8_encode($data['usuario']);
        //.......................
        //y todo el resto de datos que tenga el usuario y se pueda modificar
        //.......................
        return $DatosUsuario;
    }else
        return false;
}

function ControlesValidos() {
    $MensajeError = '';
    //voy concatenando los mensajes de error a medida q van saliendo
    $_POST['nombre'] = trim($_POST['nombre']); //limpio espacios al Nombre
    if (strlen($_POST['nombre']) < 3) {  //longitud de cada control.. 
        $MensajeError.='Debe ingresar su nombre <br />';
    }

    $_POST['apellido'] = trim($_POST['apellido']); //limpio espacios al Apellido
    if (strlen($_POST['apellido']) < 3) { //longitud de cada control.. 
        $MensajeError.='Debe ingresar su apellido <br />';
    }

    $_POST['usuario'] = trim($_POST['usuario']); //limpio espacios al Nombre
    if (strlen($_POST['usuario']) < 3) {  //longitud de cada control.. 
        $MensajeError.='Debe ingresar su usuario <br />';
    }

    $_POST['clave'] = trim($_POST['clave']); //limpio espacios al Clave
    //si la clave estuviera vacia, no la debo modificar
    //pero si tiene caracteres, entra la validacion:
    if (!empty($_POST['clave'])) {
        if (strlen($_POST['clave']) < 5) {
            $MensajeError.='La clave debe contener al menos 5 caracteres. <br />';
        }

        $_POST['reclave'] = trim($_POST['reclave']); //limpio espacios al ReClave
        if ($_POST['clave'] != $_POST['reclave']) {  //si ambos valores de clave y reClave son distintos.. error.
            $MensajeError.='Las claves no coinciden. <br />';
        }
    }
    //retorno la variable
    return $MensajeError;
}

function Modificar_Mis_Datos() {

    //recordar las comillas simples en cada valor literal q va a la consulta
    //aqui tambien debo cambiar la clave si es q viene el valor, sino no la toco.

    if (!empty($_POST['clave'])) {
        $SQL = "UPDATE socios 
            SET nombre  =   '{$_POST['nombre']}',
             apellido    =   '{$_POST['apellido']}', 
             usuario   =    '{$_POST['usuario']}',
             clave       =   MD5('{$_POST['clave']}')
          WHERE  id       =   {$_SESSION['USUARIO_ID']} ";
          
    } else {
        $SQL = "UPDATE socios 
            SET nombre  =   '{$_POST['nombre']}',
            apellido    =   '{$_POST['apellido']},'
             usuario   =    '{$_POST['usuario']}'
          WHERE  id       =   {$_SESSION['USUARIO_ID']} ";
    }

    $linkConexion = ConexionBD();
    if (!mysqli_query($linkConexion, $SQL)) {
        return false;
    } else {
        return true;
    }
}

?>
