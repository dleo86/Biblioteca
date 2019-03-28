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
//incluyo el script con las funciones referidas a los Socios
require_once 'funciones/funciones_libros.inc.php';

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
    
    
    <?php
//llamo a la funcion que devolvera el listado de Socios
    $ListadoDeGeneros = Listar_Generos();
//si el array tiene datos procedo a mostrarlos en tabla
    if (!empty($ListadoDeGeneros)) {
        ?>
        <h3>Listado de Generos</h3>
        <table border="2">
            <tr style="background-color: grey; color: #fff;">
                <td>Id</td>
                <td>Nombre</td>
                
            </tr>
            <?php
            $cantGeneros = count($ListadoDeGeneros);
            for ($i = 0; $i < $cantGeneros; $i++) {
                //repito los Renglones <tr> por cada Elemento de mi array
                /*
                 * recordar q en las tablas: 
                 * Renglon --> <tr>
                 * Dato en celda --> <td>
                 */
                ?>
                <tr>
                    <td><?php echo $ListadoDeGeneros[$i]['ID']; ?></td>                                             
                    <td><?php echo $ListadoDeGeneros[$i]['NOMBRE']; ?></td>             
                </tr>
                <?php
            } //FIN FOR
            ?>
        </table>

        <?php
    } else {
        //el array esta vacio, es decir la consulta no arroja resultados
        echo 'No hay Generos cargados a&uacute;n.';
    }
    ?>


</div>            

</body>


<?php
require_once 'includes/pie.inc.php';
//aqui no debo cerrar sesiones en el pie, sino me volvera a pedir el login
//la sesion se debe cerrar solo del link de Cerrar Sesion.
?>
