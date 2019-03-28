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
require_once 'funciones/funciones_prestamos.inc.php';

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
    $ListadoDePrestamos = Listar_Prestamos();
//si el array tiene datos procedo a mostrarlos en tabla
    if (!empty($ListadoDePrestamos)) {
        ?>
        <h3>Listado de Prestamos</h3>
        <table border="2">
            <tr style="background-color: grey; color: #fff;">
                <td>Id</td>
                <td>Apellido y Nombre</td>
                <td>Libro</td>
                <td>Fecha de prestamo</td>
                <td>Fecha de devolucion</td>
                <td>Estado</td>
                <td>Operacion</td>
            </tr>
            <?php
            $fecha_actual = date("Y-m-d H:i:00",time());
            $cantPrestamos = count($ListadoDePrestamos);
            for ($i = 0; $i < $cantPrestamos; $i++) {
                //repito los Renglones <tr> por cada Elemento de mi array
                /*
                 * recordar q en las tablas: 
                 * Renglon --> <tr>
                 * Dato en celda --> <td>
                 */
                ?>
                <tr>
                    <td><?php echo $ListadoDePrestamos[$i]['ID']; ?></td>                                             
                    <td><?php echo $ListadoDePrestamos[$i]['NOMBRE_SOCIO']; ?></td>
                    <td><?php echo $ListadoDePrestamos[$i]['NOMBRE_LIBRO']; ?></td>
                    <td><?php echo $ListadoDePrestamos[$i]['FECHA_PRESTAMO']; ?></td>
                    <td><?php echo $ListadoDePrestamos[$i]['FECHA_DEVOLUCION']; ?></td>
                    <td><?php if ($fecha_actual > $ListadoDePrestamos[$i]['FECHA_DEVOLUCION']){ 
                                 echo "Atrasado";
                              }
                              else {
                                   echo "A tiempo"; 
                                    }
                                    ?></td>
                    <td>
                        <a href='Eliminar_Prestamo.php?ID=<?php echo $ListadoDePrestamos[$i]['ID'] ?>' 
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
        echo 'No hay Prestamos cargados a&uacute;n.';
    }
    ?>


</div>            

</body>


<?php
require_once 'includes/pie.inc.php';
//aqui no debo cerrar sesiones en el pie, sino me volvera a pedir el login
//la sesion se debe cerrar solo del link de Cerrar Sesion.
?>
