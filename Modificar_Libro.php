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

/* * ******************************************************************* */
//validar el parametro q llegue por GET, para conocer que libro debo modificar
if (empty($_GET['IdLibro']) || !is_numeric($_GET['IdLibro'])) {
    //si esta vacia la variable IdLibro q viene por GET, o no es un numero, no puedo seguir operando
    //puedo validar q sea numerico, o q contenga cierta cantidad de caracteres... eso ya definen uds. 
    $_SESSION['MensajeError'] = "El id del libro que se desea modificar es incorrecto.";
    //vuelvo al listado
    header('Location: Listado_Libros_Imagen_Operaciones.php');
    exit;
}
/* * ************************************************************************ */

/* Aqui ya cuento con el ID validado. Tengo dos momentos:
 * Momento 1: si aun no presione el boton de Modificar, es decir el script se muestra directo desde q viene del listado:
 * 1.1) ya con el ID validado, debo buscar en la base de datos el registro de Libro con ese ID
 * 1.2) mostrar el formulario completando cada control con los datos del registro que devuelve la base de datos.
 * 1.3) mostrar la imagen que tuviera asociada ese libro.
 * 
 * Momento 2: ya visto el formulario, cambio algunos valores en sus controles y presiono el boton de MODIFICAR.
 * 2.1) debo validar los controles como lo hago en el Cargar_Libro.php
 * 2.2) si sube un archivo nuevo, debera subirse el nuevo y pisarse el dato anterior.
 * 2.3) Actualizar todos los datos en la base de datos
 */


//Momento 1: si aun no presione el boton de Modificar:*/
if (empty($_POST['btnModificarLibro'])) {
    //1.1) ya con el ID validado, debo buscar en la base de datos el registro de Libro con ese ID
    //la funcion devuelve un array con cada valor desde la tabla
    $DatosLibro = Traer_Datos_Libro($_GET['IdLibro']);

    /* 1.2) mostrar el formulario completando cada control con los datos del registro que devuelve la base de datos. */
        //estos valores de $DatosLibro seran ubicados en cada control del formulario 
        //ver debajo en el formulario html

    
    
} else { 
//Momento 2: ya visto el formulario, cambio algunos valores en sus controles y presiono el boton de MODIFICAR.
    
   /* 2.1) debo validar los controles como lo hago en el Cargar_Libro.php */
    if (ValidarControles_LibroNuevo() != false) {

        /** 2.2) si sube un archivo nuevo, debera subirse el nuevo archivo*/
        if (!empty($_FILES['MiArchivo']['tmp_name'])) {
            
            if (is_uploaded_file($_FILES['MiArchivo']['tmp_name'])) {
                //si el directorio no existe, lo creamos
                $CarpetaAlojamiento = "imagenes";
                if (!is_dir($CarpetaAlojamiento)) {
                    mkdir($CarpetaAlojamiento); //creo la carpeta
                    chmod($CarpetaAlojamiento, 0777); //asigno permisos para escribir
                }
                //en este caso, muevo, alojo el archivo en el servidor
                move_uploaded_file($_FILES['MiArchivo']['tmp_name'], $CarpetaAlojamiento . '/' . $_FILES['MiArchivo']['name']);
                
            } else {
                //si no puede subirse el archivo, mensaje respectivo
                $_SESSION['MensajeError'] = 'Problemas al intentar subir el archivo <strong>' . $_FILES['MiArchivo']['name'] . '</strong>';
            }
            
        }   
        
        //si no hubo errores al tratar de subir el archivo procedo al update:
        //este proceso lo hago aparte pues puedo querer cambiar la imagen, o no, 
        //si no subo archivo sigue manteniendo la misma imagen original
        if (empty($_SESSION['MensajeError'])) {
            //aqui esta todo ok, procedo a Modificar
                /* 2.3) Actualizar todos los datos en la base de datos*/
                if (Modificar_Libro($_GET['IdLibro']) != false) {
                    //si todo ok redirecciono al Listado, blanqueando el POST 
                    //y manteniendo los mensajes en la SESSION
                    $_SESSION['MensajeOk'] = "Libro modificado correctamente!";
                    header('Location: Listado_Libros_Imagen_Operaciones.php');
                    exit;
                } else {
                    //si hay errores, son de la consulta. En ese caso no vuelve al listado,
                    // se queda en el formulario.
                    $_SESSION['MensajeError'] = "No se pudo modificar el libro seleccionado. Intenta nuevamente.";
                }
            
        }
        
    }
    
    //en caso que haya errores y no se pueda redireccionar al listado, debo mantener los valores de POST 
    $DatosLibro['NOMBRE_LIBRO']=!empty($_POST['Nombre'])?$_POST['Nombre']:'';
    $DatosLibro['ID_GENERO']=!empty($_POST['Genero'])?$_POST['Genero']:'';
    $DatosLibro['ID_AUTOR']=!empty($_POST['Autor'])?$_POST['Autor']:'';
    $DatosLibro['IMAGEN']=!empty($_POST['Imagen'])?$_POST['Imagen']:'';
}




$ListadoAutores = Listar_Autores();
$cntAutores = count($ListadoAutores);
$ListadoGeneros = Listar_Generos();
$cntGeneros = count($ListadoGeneros);

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

    <form method="post" enctype="multipart/form-data" 
          action="Modificar_Libro.php?IdLibro=<?php echo $_GET['IdLibro']; ?>">
        <h2>
            Modificaci&oacute;n de Libro
        </h2>
        
        <?php if (!empty($_SESSION['MensajeError'])) { ?>
            <div style="color: red;">
                <?php echo $_SESSION['MensajeError']; ?>
            </div>
        <?php } ?>


        <?php if (!empty($_SESSION['MensajeOk'])) { ?>
            <div style="color: #13b54c;">
                <?php echo $_SESSION['MensajeOk']; ?>
            </div>
        <?php } ?>


        <h4>
            Reglas: <br />
            * Todos los datos son requeridos<br />
            * Se deben mantener los campos mientras haya error
        </h4>  
        Nombre del libro:
        <input type="text" name="Nombre" value="<?php echo $DatosLibro['NOMBRE_LIBRO']; ?>" />
        <br />
        <br />

        Autor:
        <select name="Autor">
            <option value="">Selecciona un autor...</option>

            <?php
            for ($i = 0; $i < $cntAutores; $i++) {
                $seleccionado = $DatosLibro['ID_AUTOR'] == $ListadoAutores[$i]['ID'] ? 'selected' : '';
                ?>
                <option value="<?php echo $ListadoAutores[$i]['ID'] ?>"  <?php echo $seleccionado; ?> >
                    <?php echo $ListadoAutores[$i]['NOMBRE'] ?>
                </option>
            <?php } ?>

        </select>

        <br />
        <br />

        G&eacute;nero:
        <select name="Genero">
            <option value="">Selecciona un genero...</option>

            <?php
            for ($i = 0; $i < $cntGeneros; $i++) {
                $seleccionado = $DatosLibro['ID_GENERO'] == $ListadoGeneros[$i]['ID'] ? 'selected' : '';
                ?>
                <option value="<?php echo $ListadoGeneros[$i]['ID'] ?>"  <?php echo $seleccionado; ?> >
                    <?php echo $ListadoGeneros[$i]['NOMBRE'] ?>
                </option>
            <?php } ?>
        </select>


        <?php 
        //si el libro cargado tiene una imagen ya asignada, la muestro y permito reemplazarla
        if (!empty($DatosLibro['IMAGEN'])) { ?>
            <br />
            <br />
            Imagen del libro actual: <br />
            <img src="imagenes/<?php echo $DatosLibro['IMAGEN'] ?>"  height="80px" width="50" /> 
            <?php /*
             * aqui usamos un nuevo control, de tipo HIDDEN. Este campo esta oculto, no se visualiza
             * pero existe y puede contener valores como un cuadro de text normal.
             * Aqui lo usaremos para tomar el nombre de la imagen q tuviera el libro
             * si no lo usamos, en caso q hubiera errores en la validacion, el nombre de la imagen lo perdemos
             * porque en ese momento ya no vuelve a la base de datos, 
             * los valores q tenga en el formulario son los q se mantienen */ ?>
            <input type="hidden" name="Imagen" value="<?php echo $DatosLibro['IMAGEN'] ?>" />
            <br />
            <br />
            Reemplazar la imagen:
            <input type="file" name="MiArchivo" />
            
        <?php } else { //si no tiene imagen cargada, permito subir una ?>

            <br />
            <br />
            Subir una imagen:
            <input type="file" name="MiArchivo" />

        <?php } ?>
            



        <br />
        <br />
        <input type="submit" name="btnModificarLibro" value="Modificar datos del libro" />
    </form>

</body>


<?php
require_once 'includes/pie.inc.php';
//aqui no debo cerrar sesiones en el pie, sino me volvera a pedir el login
//la sesion se debe cerrar solo del link de Cerrar Sesion.
?>
