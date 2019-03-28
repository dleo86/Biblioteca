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
require_once 'funciones/funciones_paginacion.inc.php';
$cntListadoCompleto = Total_libros();
$CantidadRegistrosPorPagina = 5;

$PaginasAMostrar = round($cntListadoCompleto / $CantidadRegistrosPorPagina);

//si me viene valor por GET de la variable de paginacion, lo uso. 
//Sino por defecto sera 0, es decir q muestre a partir del registro 0
$RegistroInicial = !empty($_GET['page']) && $_GET['page'] > 1 ? ($_GET['page'] - 1) * $CantidadRegistrosPorPagina : 0;

$ListadoLimitado = Listado_Paginado($RegistroInicial, $CantidadRegistrosPorPagina);
$cntListadoLimitado = count($ListadoLimitado);
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
    //LE AGREGAMOS EL CAMPO "ACTIVO" en la consulta
    $ListadoDeLibros = Listar_Libros();
//si el array tiene datos procedo a mostrarlos en tabla
    if (!empty($ListadoDeLibros)) {
        ?>
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

        <h3>Listado de Libros con Imagen y Operaciones</h3>

        <table border="2">
            <tr style="background-color: grey; color: #fff;">
                <td># Id</td>
                <td>Nombre del Libro</td>
                <td>Nombre del G&eacute;nero</td>
                <td>Autor</td>
                <td>Fecha de Registro</td>
                <td>Imagen</td>
                <td colspan="4">Operaciones</td>

            </tr>
            <?php
            $cantLibros = count($ListadoDeLibros);
            //echo $PaginasAMostrar;
            //echo $cntListadoLimitado;
            for ($i = 0; $i < $cntListadoLimitado; $i++) {
                //repito los Renglones <tr> por cada Elemento de mi array
                /*
                 * recordar q en las tablas: 
                 * Renglon --> <tr>
                 * Dato en celda --> <td>       
                 */
                ?>
                <tr>
                    <td><?php echo $ListadoLimitado[$i]['ID_LIBRO']; ?></td>                                             
                    <td><?php echo $ListadoLimitado[$i]['NOMBRE_LIBRO']; ?></td>
                    <td><?php echo $ListadoLimitado[$i]['NOMBRE_GENERO']; ?></td>
                    <td><?php echo $ListadoLimitado[$i]['AUTOR']; ?></td>
                    <td><?php echo $ListadoLimitado[$i]['FECHA_REGISTRO']; ?></td>
                    <td><img src="imagenes/<?php echo $ListadoLimitado[$i]['IMAGEN']; ?>" height="120px" width="85px" /> </td> 
                    
                    <td>
                        <?php
                        //si el Activo = 1, procedo a Desactivar el libro. Si el Activo!=1, procedo a Activarlo.
                        if ($ListadoLimitado[$i]['DISPONIBLE']==1) {
                            //Envio dos valores por GET, 
                            //1) para q sepa si es Activar o Desactivar [aqui uso la palabra segun el caso, pueden usar un nro, un codigo, etc]
                            //2) el ID del libro q voy a actualizar su estado
                        
                        ?>
                        <a href='Activacion_Libro.php?Accion=No disponible&IdLibro=<?php echo $ListadoLimitado[$i]['ID_LIBRO'] ?>' >
                            No disponible
                        </a>
                        <?php }else {  ?>
                        <a href='Activacion_Libro.php?Accion=Disponible&IdLibro=<?php echo $ListadoLimitado[$i]['ID_LIBRO'] ?>' >
                            Disponible
                        </a>
                        
                        <?php } ?>
                        
                    </td>
                    <td><a href=''>Prestamo</a></td>
                    <td><a href='Modificar_Libro.php?IdLibro=<?php echo $ListadoLimitado[$i]['ID_LIBRO'] ?>'>Modificar</a></td>                              
                    
                    <td>
                        <a href='Eliminar_Libro.php?IdLibro=<?php echo $ListadoLimitado[$i]['ID_LIBRO'] ?>' 
                           onclick="javascript: if (confirm('Confirma eliminar este registro?')){return true;} else {return false;}" >
                            Eliminar
                        </a>
                    </td>
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
     <?php
            //agrego el link a la pagina anterior 
            //si no tengo la variable q viaja por GET, debo mostrar el listado de la pagina 1, y el Anterior no debe ser link
            if (empty($_GET['page'])) {
                $PaginaAnterior = '';
                
            } else if ($_GET['page'] == 1) {
                //si tengo la variable q viaja por GET, y es la primer pagina, debo mostrar el listado de la pagina 1, y el Anterior tampoco debe ser link
                $PaginaAnterior = '';
                
            } else if ($_GET['page'] < $PaginasAMostrar) {
                //si tengo la variable GET y es alguna pagina intermedia, agrego 1 para la proxima page
                $PaginaAnterior = '?page=' . ($_GET['page'] - 1);
            }

            //se mostrara si estoy en la pagina 2 o superior.
            //No deberia ver una pagina anterior si estoy en la pagina 1 con los primeros registros
            if (!empty($PaginaAnterior)) {
                ?> 
                <a href="Listado_Libros_Imagen_Operaciones.php<?php echo $PaginaAnterior; ?>" >Anterior </a>
            <?php } else { ?>
                Anterior
            <?php } ?>


            <?php for ($j = 1; $j <= $PaginasAMostrar; $j++) { ?>
                * <a href="Listado_Libros_Imagen_Operaciones.php?page=<?php echo $j; ?>"> <?php echo $j; ?> </a>
            <?php } ?>


            <?php
            //agrego el link a la pagina siguiente 
            //si no tengo la variable q viaja por GET, debo mostrar el listado de la pagina 1, y el Siguiente apunta a la page 2
            if (empty($_GET['page'])) {
                $PaginaSiguiente = '?page=2';
            } else if ($_GET['page'] < $PaginasAMostrar) {
                //si tengo la variable GET y es alguna pagina intermedia, agrego 1 para la proxima page
                $PaginaSiguiente = '?page=' . ($_GET['page'] + 1);
            } else if ($_GET['page'] == $PaginasAMostrar) {
                //si la variable GET tiene el valor de la ultima pagina, no le doy valor al Siguiente
                $PaginaSiguiente = '';
            }

            if (!empty($PaginaSiguiente)) {
                ?> 
                * <a href="Listado_Libros_Imagen_Operaciones.php<?php echo $PaginaSiguiente; ?>" >Siguiente </a>
            <?php } else { ?>
                Siguiente
            <?php } ?>

</div>            

</body>


<?php
require_once 'includes/pie.inc.php';
//aqui no debo cerrar sesiones en el pie, sino me volvera a pedir el login
//la sesion se debe cerrar solo del link de Cerrar Sesion.
?>
