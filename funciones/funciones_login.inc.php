<?php
function ControlesValidosLogin() {
    $MensajeError = '';
    $_POST['Login'] = strip_tags($_POST['Login']);  //limpio el valor de Post 
    $_POST['Clave'] = strip_tags($_POST['Clave']);
    //http://www.desarrolloweb.com/faq/eliminar-etiquetas-html-php-string.html
    
    $_POST['Login'] = trim($_POST['Login']); //limpio espacios al Login
    if (strlen($_POST['Login']) < 5) { //verifico longitud 
        $MensajeError.='El login es incorrecto <br />';
    }
    
    $_POST['Clave'] = trim($_POST['Clave']); //limpio espacios al Clave
    if (strlen($_POST['Clave']) == 0) {  //verifico longitud 
        $MensajeError.='La clave es incorrecta <br />';
    }
    
    return $MensajeError;
}

function DatosUsuarioCorrecto($User, $Pass) {

    $DatosUsuario = array();
    //genero la consulta sql con los parametros enviados
    //entre comillas simples cada parametro por ser cadenas
    //si fueran numeros no haria falta q lleven comillas simples
    $SQL = "SELECT id, nombre, apellido, nivel FROM socios WHERE usuario='$User' AND clave = '$Pass'";
    //genero la conexion
    $linkConexion = ConexionBD();
    $rs = mysqli_query($linkConexion, $SQL);
    //por ser un solo registro el q debo traer, no aplico while
    $data = mysqli_fetch_array($rs);
    //si $data trajo algo, entonces cargo mis valores
    if ($data != false) {
        $DatosUsuario['ID'] = $data['id'];
        $DatosUsuario['NOMBRE_SOCIO'] = utf8_encode($data['apellido']) . ", " . utf8_encode($data['nombre']);
        $DatosUsuario['USUARIO'] = $data['usuario'];
        $DatosUsuario['CLAVE'] = $data['clave'];
        $DatosUsuario['FECHA_REGISTRACION'] = $data[4];
        $DatosUsuario['NIVEL'] = $data['nivel'];
        return $DatosUsuario;
    }else
        return false;
}

?>