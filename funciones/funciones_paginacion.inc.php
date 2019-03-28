<?php
function Total_libros(){
    $vTotalRegistros=0;
    
    $vConexion = ConexionBD();
    
    if ($vConexion !== false) {
        $vSQL = "SELECT count(*) as CantidadTotalRegistros FROM libros";

        $rs = mysqli_query($vConexion, $vSQL);
        if (!$rs) {
            return false;
        } else {
            $data = mysqli_fetch_assoc($rs);
            $vTotalRegistros= $data['CantidadTotalRegistros'];
            mysqli_close($vConexion);
            return $vTotalRegistros;
        }

        mysqli_close($vConexion);
        return false;
    }
}


function Listado_Paginado($vRegistroInicial , $vCantidadParaMostrar){
    //Esta funcion traera LIMITADA la consulta
    // --> Desde el registro dado en el primer parametro
    // --> contando tantos registros como indique el 2do parametro
    $Listado = array();
    $vConexion = ConexionBD();
    
    if ($vConexion !== false) {
        $vSQL = "SELECT L.id as IdLibro, L.nombre as NombreLibro, G.nombre AS NombreGenero, 
                  A.nombre AS NombreAutor, A.apellido AS ApellidoAutor, L.disponible AS Disponible,
                  L.imagen AS Imagen, L.fecha_carga AS FechaRegistro
                FROM libros L, generos G, autores A
                WHERE L.id_genero=G.id AND L.id_autor=A.id
                ORDER BY L.id
                LIMIT $vRegistroInicial  , $vCantidadParaMostrar ";         
       // echo $vSQL; //pueden ir mostrando la sql para ver como van cambiando los parametros del LIMIT
        
        $rs = mysqli_query($vConexion, $vSQL);
        if (!$rs) {
            return false;
        } else {

            $i = 0;
            while ($data = mysqli_fetch_assoc($rs)) {
               $Listado[$i]['ID_LIBRO'] = $data['IdLibro'];
               $Listado[$i]['NOMBRE_LIBRO'] = utf8_encode($data['NombreLibro']);
               $Listado[$i]['NOMBRE_GENERO'] = utf8_encode($data['NombreGenero']);
               $Listado[$i]['AUTOR'] = utf8_encode($data['ApellidoAutor']).', '.utf8_encode($data['NombreAutor']);
               $Listado[$i]['FECHA_REGISTRO'] = $data['FechaRegistro'];
               $Listado[$i]['IMAGEN'] = $data['Imagen'];
               $Listado[$i]['DISPONIBLE'] = $data['Disponible'];
               $i++;
            }
            mysqli_close($vConexion);
            return $Listado;
        }

        mysqli_close($vConexion);
        return false;
    }
}

?>