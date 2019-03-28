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
//llamo a la funcion que devolvera el listado de Libros
    $ListadoDeLibros = Listar_Libros();
//si el array tiene datos procedo a mostrarlos en tabla
    if (!empty($ListadoDeLibros)) {
        ?>
        <h3>Listado de Libros</h3>
        <table border="2">
            <tr style="background-color: grey; color: #fff;">
                <td># Id</td>
                <td>Nombre del Libro</td>
                <td>Nombre del G&eacute;nero</td>
                <td>Autor</td>
                <td>Fecha de Registro</td>
            </tr>
            <?php
            $cantLibros = count($ListadoDeLibros);
            for ($i = 0; $i < $cantLibros; $i++) {
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
                </tr>
                <?php
            } //FIN FOR
            ?>
        </table>

        <?php
    } else {
        //el array esta vacio, es decir la consulta no arroja resultados
        echo 'No hay Libros cargados a&uacute;n.';
    }
    ?>


</div>            

</body>


<?php
require_once 'includes/pie.inc.php';
//aqui no debo cerrar sesiones en el pie, sino me volvera a pedir el login
//la sesion se debe cerrar solo del link de Cerrar Sesion.
?>
