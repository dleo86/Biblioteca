<?php

function Listar_Autores() {
    $Listado = array();
    $MiConexion = ConexionBD();
    if ($MiConexion != false) {
        $SQL = "SELECT id, nombre, apellido FROM autores";
        $rs = mysqli_query($MiConexion, $SQL);
        $i = 0;
        while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['ID'] = $data['id'];
            $Listado[$i]['NOMBRE'] = utf8_encode($data['nombre']);
            $Listado[$i]['APELLIDO'] = utf8_encode($data['apellido']);
            $i++;
        }
    }

    return $Listado;
}

function Listar_Generos() {
    $Listado = array();
    $MiConexion = ConexionBD();
    if ($MiConexion != false) {
        $SQL = "SELECT id, nombre FROM generos";
        $rs = mysqli_query($MiConexion, $SQL);
        $i = 0;
        while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['ID'] = $data['id'];
            $Listado[$i]['NOMBRE'] = utf8_encode($data['nombre']);
            $i++;
        }
    }

    return $Listado;
}

function ValidarControles_LibroNuevo() {
    $_SESSION['MensajeError'] = '';
    //recorro el array de POST 
    foreach ($_POST as $IdPost => $ValorPost) {
        //limpio espacios
        $_POST[$IdPost] = trim($ValorPost);
        //limpio caracteres indebidos
        $_POST[$IdPost] = strip_tags($ValorPost);
    }

    //por cada control voy validando su contenido y concatenando el mensaje
    if (empty($_POST['Nombre'])) {
        $_SESSION['MensajeError'].='Debes ingresar el Nombre del libro.<br />';
    }
    if (empty($_POST['Autor']) || !is_numeric($_POST['Autor'])) {
        $_SESSION['MensajeError'].='Debes seleccionar el Autor.<br />';
    }
    if (empty($_POST['Genero']) || !is_numeric($_POST['Genero'])) {
        $_SESSION['MensajeError'].='Debes seleccionar el Genero.<br />';
    }
    //devolvera true o false segun la variable contenga los errores
    if (!empty($_SESSION['MensajeError'])) {
        return false;
    }else
        return true;
}

function Insertar_Libro() {
    $SQL = "INSERT INTO libros(nombre, descripcion, id_autor, id_genero, fecha_carga, imagen) 
        VALUES ('{$_POST['Nombre']}'  ,'{$_POST['Descripcion']}', {$_POST['Autor']} ,  {$_POST['Genero']}  , now() , '{$_FILES['MiArchivo']['name']}'  )";

    $MiConexion = ConexionBD();
    if (!mysqli_query($MiConexion, $SQL)){
        return false;
    }else {
        return true;
    }
}


function Listar_Libros() {
    $Listado = array();
    $MiConexion = ConexionBD(); // AND L.Activo=1
    if ($MiConexion != false) {
        $SQL = "SELECT L.id as IdLibro, L.nombre as NombreLibro, G.nombre AS NombreGenero, 
                A.nombre AS NombreAutor, A.apellido AS ApellidoAutor, L.disponible AS Disponible,
                L.imagen AS Imagen, L.fecha_carga AS FechaRegistro
                FROM libros L, generos G, autores A
                WHERE L.id_genero=G.Id AND L.id_autor=A.id            
               
                ORDER BY L.fecha_carga DESC ";
        $rs = mysqli_query($MiConexion, $SQL);
        $i = 0;
        while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['ID_LIBRO'] = $data['IdLibro'];
            $Listado[$i]['NOMBRE_LIBRO'] = utf8_encode($data['NombreLibro']);
            $Listado[$i]['NOMBRE_GENERO'] = utf8_encode($data['NombreGenero']);
            $Listado[$i]['AUTOR'] = utf8_encode($data['ApellidoAutor']).', '.utf8_encode($data['NombreAutor']);
            $Listado[$i]['FECHA_REGISTRO'] = $data['FechaRegistro'];
            $Listado[$i]['IMAGEN'] = $data['Imagen'];
            $Listado[$i]['DISPONIBLE'] = $data['Disponible'];
            $i++;
        }
    }

    return $Listado;
}

function Activacion_Libro($Disponible, $IdLibro) {
    //aseguro el dato q voy a actualizar en la tabla: q sea 0 o 1.
    if ($Disponible == 1 || $Disponible == 0) {
        $SQL = "UPDATE libros SET disponible=$Disponible WHERE id=$IdLibro";

        $MiConexion = ConexionBD();
        if (!mysqli_query($MiConexion, $SQL)) {
            return false;
        } else {
            return true;
        }
    } else
        return false;
}

function Eliminar_Libro($IdLibro) {
    $SQL = "DELETE FROM libros WHERE id=$IdLibro";

    $MiConexion = ConexionBD();
    if (!mysqli_query($MiConexion, $SQL)) {
        return false;
    } else {
        return true;
    }
}

function Traer_Datos_Libro($IdLibro) {
    $DatosLibro = array();

    $MiConexion = ConexionBD();
    if ($MiConexion != false) {
        $SQL = "SELECT id, nombre, id_autor, id_genero, imagen 
                FROM libros 
                WHERE id=$IdLibro ";

        $rs = mysqli_query($MiConexion, $SQL);
        $i = 0;
        //Aqui sera un unico registro, 
        //asique no hace falta un while q recorra y arme un listado
        //$DatosLibro['ACTIVO'] = $data['Activo'];
        $data = mysqli_fetch_array($rs);
        $DatosLibro['ID_LIBRO'] = $data['id'];
        $DatosLibro['NOMBRE_LIBRO'] = utf8_encode($data['nombre']);
        $DatosLibro['ID_AUTOR'] = $data['id_autor'];
        $DatosLibro['ID_GENERO'] = $data['id_genero'];
        
        $DatosLibro['IMAGEN_LIBRO'] = $data['imagen'];
    }

    return $DatosLibro;
}

function Modificar_Libro($IdLibro) {
    //debo considerar q segun nuestra programacion, el usuario puede querer
    //subir una imagen, o querer mantener la q tiene el libro.
    //Por esto pregunto si el archivo viene con contenido, 
    //       de ser asi modifico el nombre de la imagen,
    //sino
    //       no toco ese dato y modifico solamente el resto.
    if (!empty($_FILES['MiArchivo']['name'])) {
        $SQL = "UPDATE libros 
            SET nombre='{$_POST['Nombre']}' ,
            id_autor= {$_POST['Autor']} , 
            id_genero= {$_POST['Genero']} ,
            imagen='{$_FILES['MiArchivo']['name']}'
            WHERE id=$IdLibro";
    } else {
        $SQL = "UPDATE libros 
            SET nombre='{$_POST['Nombre']}' ,
            id_autor= {$_POST['Autor']} , 
            id_genero= {$_POST['Genero']} 
            WHERE id=$IdLibro";
    }


    $MiConexion = ConexionBD();
    if (!mysqli_query($MiConexion, $SQL)) {
        return false;
    } else {
        return true;
    }
}

function Buscar_Libros_Basico($Patron_Nombre_Ingresado) {
    
    //casi replica de la funcion Listar_Libros(): aqui se agrega el filtro en el WHERE
    $Listado = array();
    $MiConexion = ConexionBD();
    
    if ($MiConexion != false) {
        $SQL = "SELECT L.id as IdLibro, L.nombre as NombreLibro, G.nombre AS NombreGenero, 
            A.nombre AS NombreAutor, A.apellido AS ApellidoAutor, 
            L.fecha_carga AS FechaRegistro , L.imagen as Imagen, L.disponible as Activo
                FROM libros L, generos G, autores A
                WHERE L.id_genero=G.id AND L.id_autor=A.id     
                AND L.nombre like '%$Patron_Nombre_Ingresado%'
                ORDER BY L.fecha_carga asc ";

        $rs = mysqli_query($MiConexion, $SQL);
        $i = 0;
        while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['ID_LIBRO'] = $data['IdLibro'];
            $Listado[$i]['NOMBRE_LIBRO'] = utf8_encode($data['NombreLibro']);
            $Listado[$i]['NOMBRE_GENERO'] = utf8_encode($data['NombreGenero']);
            $Listado[$i]['AUTOR'] = utf8_encode($data['ApellidoAutor']) . ', ' . utf8_encode($data['NombreAutor']);
            $Listado[$i]['FECHA_REGISTRO'] = $data['FechaRegistro'];
            $Listado[$i]['IMAGEN_LIBRO'] = $data['Imagen'];
            $Listado[$i]['ACTIVO'] = $data['Activo'];
            $i++;
        }
    }

    return $Listado;
}

function Buscar_Libros_Avanzado($Patron_Nombre_Ingresado, $Patron_Genero_Ingresado) {
    
    //casi replica de la funcion Buscar_Libros_Basico(): aqui se agrega el filtro del Genero
    $Listado = array();
    
    
    $MiConexion = ConexionBD();
    
    if ($MiConexion != false) {
        //armo la consulta basica
        $SQL = "SELECT L.id as IdLibro, L.nombre as NombreLibro, G.nombre AS NombreGenero, 
            A.nombre AS NombreAutor, A.apellido AS ApellidoAutor, 
            L.fecha_carga AS FechaRegistro , L.imagen as Imagen, L.disponible as Activo
                FROM libros L, generos G, autores A
                WHERE L.id_genero=G.id AND L.id_autor=A.id     ";
        
        //y segun el filtro que llegue, le voy concatenando los filtros
        //si llega el filtro del Nombre del ibro:
        if (!empty($Patron_Nombre_Ingresado)) {
            $SQL.="  AND L.nombre like '%$Patron_Nombre_Ingresado%' ";
        }
        
        //si llega el filtro del Genero del ibro:
        if (!empty($Patron_Genero_Ingresado)) {
            $SQL.="  AND G.id = $Patron_Genero_Ingresado ";
        }
        //finamente concateno el Order By
        $SQL.="  ORDER BY L.fecha_carga  ";

        
        
        $rs = mysqli_query($MiConexion, $SQL);
        $i = 0;
        while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['ID_LIBRO'] = $data['IdLibro'];
            $Listado[$i]['NOMBRE_LIBRO'] = utf8_encode($data['NombreLibro']);
            $Listado[$i]['NOMBRE_GENERO'] = utf8_encode($data['NombreGenero']);
            $Listado[$i]['AUTOR'] = utf8_encode($data['ApellidoAutor']) . ', ' . utf8_encode($data['NombreAutor']);
            $Listado[$i]['FECHA_REGISTRO'] = $data['FechaRegistro'];
            $Listado[$i]['IMAGEN_LIBRO'] = $data['Imagen'];
            $Listado[$i]['ACTIVO'] = $data['Activo'];
            $i++;
        }
    }

    return $Listado;
}

?>
