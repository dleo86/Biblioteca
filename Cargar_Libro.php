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


if (!empty($_POST['btnRegistrarLibro'])) {
    //debo validar cada elemento previo a ser insertado en la base
    //la funcion almacena el mensaje con errores en la variable de sesion
    //y devuelve true o false segun ese mensaje tenga o no valor
    if (ValidarControles_LibroNuevo()!=false){
        //aqui está todo ok, procedo a registrar
        if (Insertar_Libro() != false) {
            //si todo ok redirecciono al mismo script, blanqueando el POST 
            //y manteniendo los mensajes en la SESSION
            $_SESSION['MensajeOk']="Libro registrado correctamente!";
            header('Location: Cargar_Libro.php');
            exit;
        }else {
            $_SESSION['MensajeError']="No se pudo registrar el libro. Intenta nuevamente.";
        }
    }
    
}




$ListadoAutores=Listar_Autores();
$cntAutores=count($ListadoAutores);
$ListadoGeneros=Listar_Generos();
$cntGeneros=count($ListadoGeneros);

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

    <form method="post">
        <h2>
            Registro de nuevo libro
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
        <input type="text" name="Nombre" value="<?php echo!empty($_POST['Nombre']) ? $_POST['Nombre'] : ''; ?>" />
        <br />
        <br />

        Autor:
        <select name="Autor">
            <option value="">Selecciona un autor...</option>

            <?php 
            for($i=0; $i<$cntAutores; $i++) { 
                $seleccionado=!empty($_POST['Autor']) && $_POST['Autor']==$ListadoAutores[$i]['ID'] ? 'selected' : '' ; 
                ?>
            <option value="<?php echo $ListadoAutores[$i]['ID']?>"  <?php echo $seleccionado; ?> >
                <?php echo $ListadoAutores[$i]['APELLIDO'] ?>
            </option>
            <?php } ?>
            
        </select>
        
        <br />
        <br />
        
        G&eacute;nero:
        <select name="Genero">
            <option value="">Selecciona un genero...</option>
            
            <?php for($i=0; $i<$cntGeneros; $i++) { 
                $seleccionado=!empty($_POST['Genero']) && $_POST['Genero']==$ListadoGeneros[$i]['ID'] ? 'selected' : '' ; 
                ?>
            <option value="<?php echo $ListadoGeneros[$i]['ID'] ?>"  <?php echo $seleccionado; ?> >
                <?php echo $ListadoGeneros[$i]['NOMBRE'] ?>
            </option>
            <?php } ?>
            
        </select>
        
        <br />
        <br />
        <input type="submit" name="btnRegistrarLibro" value="Cargar" />
    </form>

</body>


<?php
require_once 'includes/pie.inc.php';
//aqui no debo cerrar sesiones en el pie, sino me volvera a pedir el login
//la sesion se debe cerrar solo del link de Cerrar Sesion.
?>
