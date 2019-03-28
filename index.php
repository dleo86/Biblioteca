<?php
session_start();
//si la variable de sesion esta vacia, no debe poder entrar al panel
//redirecciono al logueo
if (empty($_SESSION['USUARIO_ID'])) {
    header('Location: login.php');
    exit;
}

//en este script por ahora no hace falta conexion a la BD


//incluyo el script con el encabezado del archivo principal
require_once 'includes/header.inc.php';
?>
<body>
    <div>
        <?php require_once 'includes/user.inc.php'; ?>
        <hr />
        
        <?php if ($_SESSION['USUARIO_NIVEL'] == 1){ 
                  require_once 'includes/menu.inc.php';
                }
              else {
              	  require_once 'includes/menu1.inc.php';
                } ?>
        <hr />
    </div>            

    <img src="images/panel.png" />
    
</body>
<?php
require_once 'includes/pie.inc.php';
//aqui no debo cerrar sesiones en el pie, sino me volvera a pedir el login
//la sesion se debe cerrar solo del link de Cerrar Sesion.
?>
