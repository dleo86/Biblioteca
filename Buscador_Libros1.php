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
//incluyo el script con las funciones referidas a los Libros
require_once 'funciones/funciones_libros.inc.php';

$ListadoDeLibros=array();

//si pulso el boton de buscar,
if (!empty($_POST['btnBuscarLibros'])) {
    //limpio de espacios el filtro ingresado
    $_POST['PatronNombre']=trim($_POST['PatronNombre']);
    
    //valido q el filtro al menos tenga valor
    if (!empty($_POST['PatronNombre'])) {
        $ListadoDeLibros=Buscar_Libros_Basico($_POST['PatronNombre']);
        if (!empty($ListadoDeLibros)) {
            $_SESSION['MensajeOk']='Se encontraron '.count($ListadoDeLibros).' registros con ese filtro de b&uacute;squeda.';
        }else {
            $_SESSION['MensajeError']='Esta b&uacute;squeda no arroja resultados.';
        }
        
        
    }else {
        $_SESSION['MensajeError']='El filtro debe llevar algun valor para poder buscar.';
    }
    
}



//incluyo el script con el encabezado del archivo principal
require_once 'includes/header.inc.php';
?>
<body>

    <div>

        <?php require_once 'includes/user.inc.php'; ?>
        <hr />

        <?php require_once 'includes/menu.inc.php'; ?>
        <hr />
    </div>   



    <?php if (!empty($_SESSION['MensajeOk'])) { ?>
    <p style="color: #13b54c;">
        <?php echo $_SESSION['MensajeOk']; ?>
    </p>
    <?php } ?>
    <?php if (!empty($_SESSION['MensajeError'])) { ?>
    <p style="color: #f00;">
        <?php echo $_SESSION['MensajeError']; ?>
    </p>
    <?php } ?>


    <h3>Buscador de Libros </h3>

    <form method="post">
        Ingresa parte del nombre del libro: 
        <input type="text" name="PatronNombre" value="<?php echo !empty($_POST['PatronNombre'])? $_POST['PatronNombre']: ''; ?>" />
        <br />
        <br />
        <input type="submit" name="btnBuscarLibros" value="Buscar" />
    </form>

    <?php if (!empty($ListadoDeLibros)) { ?>
    
    <table border="2">
        <tr style="background-color: grey; color: #fff;">
            <td># Id</td>
            <td>Nombre del Libro</td>
            <td>Nombre del G&eacute;nero</td>
            <td>Autor</td>
            <td>Fecha de Registro</td>
            <td>Imagen</td>

        </tr>
        <?php
        $cantLibros = count($ListadoDeLibros);
        for ($i = 0;
        $i < $cantLibros;
        $i++) {
        //repito los Renglones <tr> por cada Elemento de mi array
        /*
         * recordar q en las tablas: 
         * Renglon --> <tr>
         * Dato en celda --> <td>
         */
        ?>
        <tr>
            <td><?php echo $ListadoDeLibros[$i]['ID_LIBRO']; ?></td>                                             
            <td><?php echo $ListadoDeLibros[$i]['NOMBRE_LIBRO']; ?></td>
            <td><?php echo $ListadoDeLibros[$i]['NOMBRE_GENERO']; ?></td>
            <td><?php echo $ListadoDeLibros[$i]['AUTOR']; ?></td>
            <td><?php echo $ListadoDeLibros[$i]['FECHA_REGISTRO']; ?></td>
            <td><img src="imagenes/<?php echo $ListadoDeLibros[$i]['IMAGEN_LIBRO']; ?>" height="120px" width ="80px" /> </td>
        </tr>
        <?php
        } //FIN FOR
        ?>
    </table>

    <?php
    }
    ?>



</body>


<?php
require_once 'includes/pie.inc.php';
//aqui no debo cerrar sesiones en el pie, sino me volvera a pedir el login
//la sesion se debe cerrar solo del link de Cerrar Sesion.
?>
