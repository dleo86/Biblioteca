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
//y las funciones referidas a los usuarios
require_once 'funciones/funciones_usuario.inc.php';


//cuando pulse el boton de modificar, debere actualizar mis datos
if (!empty($_POST['btnModificarMisDatos'])) {
    //procedo a validar mis datos personales
    $_SESSION['MensajeError'] = ControlesValidos();

    //si no hay errores, la variable estara vacia
    if (empty($_SESSION['MensajeError'])) {
        if (Modificar_Mis_Datos() != false) {
            $_SESSION['MensajeOk'] = 'Tus datos se actualizaron correctamente.';
            //una vez actualizado en la base de datos, procedo a actualizar mis datos de sesion:
            $_SESSION['USUARIO_NOMBRE'] = $_POST['apellido'] . ', ' . $_POST['nombre'];
            //para q se refleje en la seccion superior de los datos de usuario.
            header('Location: Mis_Datos.php');
            exit;
        } else {
            $_SESSION['MensajeError'] = 'Los datos no se pudieron cargar. Intenta nuevamente.';
        }
    }
}

//si el boton no esta presionado, debere mostrar mis datos en cada control del formulario
$MisDatos = Ver_Mis_Datos();



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
    
    <h2>
        Modificaci&oacute;n Mis Datos
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
    
    
    <form method="post">
        Nombre:
<?php //por defecto mostrara mis datos personales, si pulso el boton viajan los POST y mantengo ese valor   ?>
        <input type="text" name="nombre" value="<?php echo!empty($_POST['nombre']) ? $_POST['nombre'] : $MisDatos['NOMBRE']; ?>" />
        <br />
        <br />

        Apellido:
<?php //por defecto mostrara mis datos personales, si pulso el boton viajan los POST y mantengo ese valor   ?>
        <input type="text" name="apellido" value="<?php echo!empty($_POST['apellido']) ? $_POST['apellido'] : $MisDatos['APELLIDO']; ?>" />

        <br />
        <br />
        Usuario:
<?php //por defecto mostrara mis datos personales, si pulso el boton viajan los POST y mantengo ese valor   ?>
        <input type="text" name="usuario" value="<?php echo!empty($_POST['usuario']) ? $_POST['usuario'] : $MisDatos['USUARIO']; ?>" />
        <br />
        <br />
        Ingresa tu nueva clave: (si la dejas en blanco, se mantiene la actual).
<?php //aqui no mantengo valores, pues la idea es cambiarla si ingreso datos. Valido nomas.   ?>
        <input type="password" name="clave"  />
        <br />
        <br />

        Reingresa tu nueva clave:
        <input type="password" name="reclave" />

        <br />
        <br />
        <input type="submit" name="btnModificarMisDatos" value="Modificar mis datos" />
    </form>

</body>


<?php
require_once 'includes/pie.inc.php';
//aqui no debo cerrar sesiones en el pie, sino me volvera a pedir el login
//la sesion se debe cerrar solo del link de Cerrar Sesion.
?>
