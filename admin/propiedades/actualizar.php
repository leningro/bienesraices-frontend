<?php 
    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if(!$auth) {
        header('Location: /');
    }

    //Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    //si la URL no tiene un id valido lo redirecciona
    if(!$id) {
        header('Location: /admin');
    }

    //base de datos
    require '../../includes/config/database.php';
    $db = conectarDB();

    //Obtener los datos de la propiedad a actualizar
    $consulta = "SELECT * FROM propiedades WHERE id={$id}";
    $resultado = mysqli_query($db, $consulta);
    $propiedad = mysqli_fetch_assoc($resultado); //Como solo es 1

    // echo "<pre>";
    // var_dump($propiedad);
    // echo "</pre>";

    //Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db,$consulta);

    //Arreglo con los mensajes de errores
    $errores = [];

    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamiento = $propiedad['estacionamiento'];
    $vendedores_id = $propiedad['vendedores_id'];
    /*
        En cuanto a rellenar la imagen: no es bueno hacerlo
        revela la ubicación de los archivos, así que no es 
        conveniente.

        Solo podemos mostrar dicha imagen que ya se ha seleccionado
    */
    $imagenPropiedad = $propiedad['imagen'];


    //Almacenar en variables los inputs al enviar el formulario con metodo POST
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //Esto es par ver en pantalla los datos del POST que se enviaron en el formulario
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        // echo "<pre>";
        // var_dump($_FILES);
        // echo "</pre>";


        //mysqli_real_escape_string() -> SANITIZA los datos de los input para que no haya intección SQL o algo similar 
        $titulo = mysqli_real_escape_string( $db, $_POST['titulo'] );
        $precio = mysqli_real_escape_string( $db, $_POST['precio'] );
        $descripcion = mysqli_real_escape_string( $db, $_POST['descripcion'] );
        $habitaciones = mysqli_real_escape_string( $db, $_POST['habitaciones'] );
        $wc = mysqli_real_escape_string( $db, $_POST['wc'] );
        $estacionamiento = mysqli_real_escape_string( $db, $_POST['estacionamiento'] );
        $vendedores_id = mysqli_real_escape_string( $db, $_POST['vendedores_id'] );
        $creado = date('Y/m/d');

        // Asignar files hacia una variable
        $imagen = $_FILES['imagen'];

        if(!$titulo) {
            //$arr[] = 1 -> Sintaxis para meter un elemento al final de un arreglo
            $errores[] = "Debes añadir un titulo"; 
        }
        if(!$precio) {
            $errores[] = "El precio es obligatorio";
        }
        if(strlen($descripcion) < 50) {
            $errores[] = "La descripción es obligatoria y debe tener al menos 50 caracteres";
        }
        if(!$habitaciones) {
            $errores[] = "El número de habitaciones es obligatorio";
        }
        if(!$wc) {
            $errores[] = "El número de baños es obligatorio";
        }
        if(!$estacionamiento) {
            $errores[] = "El número de estacionamientos es obligatorio";
        }
        if(!$vendedores_id) {
            $errores[] = "El vendedor es obligatorio";
        }

        //Validar por tamaño (100 Kb máximo)
        $media = 1000 * 100;

        //DATO: php limita una imagen a 2 MG. Por lo tanto en $_FILES size dara 0 y error dara 1 
        if($imagen['size'] > $media) {
            $errores[] = "La imagen es muy pesada";
        }

        //Revisar que el array del errores este vacio 
        if(empty($errores)) {

            /* SUBIDA DE ARCHIVOS */

            //declaramos ruta de la carpeta
            $carpetaImagenes = '../../imagenes/';

            //comprueba si ya existe la ruta 
            if(!is_dir($carpetaImagenes)) {
                //como no existe crea el directorio/carpeta
                mkdir($carpetaImagenes);
            }

            $nombreImagen = '';

            //¿Hay una nueva imagen?
            if($imagen['name']) {
                //Eliminar la imagen previa 
                unlink($carpetaImagenes . $propiedad['imagen']);

                //Genera un nombre unico 
                $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

                //mueve archivos de una ruta a otra. En este caso la ruta temporal a la ruta de nuestra carpeta 
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );
            }else {
                $nombreImagen = $propiedad['imagen'];
            }
            

            /* INSERTANDO EN LA BASE DE DATOS */
            $query = " UPDATE propiedades SET titulo = '{$titulo}', precio = '{$precio}', imagen = '{$nombreImagen}', descripcion = '{$descripcion}', habitaciones = {$habitaciones}, wc = {$wc}, vendedores_id = {$vendedores_id} WHERE id = {$id} ";

            //El $resultado da true o false si el query se realizo correctamente en la $db
            $resultado = mysqli_query($db, $query);

            if($resultado) {
                //Redireccionar al usuario 

                //query string -> url con algunos parametros
                header('Location: /admin?resultado=2');
            }
        }

    }

    //template del header
    incluirTemplate('header');    
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Actualizar Propiedad</h1>

        <a href="/admin" class="boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <!--El enctype="multipart/form-data" en el <form> sierve para poder recibir subida de archivos--> 
        <form method="POST" class="formulario" enctype="multipart/form-data">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo</label>
                <input type="text" id="titulo" name="titulo" placeholder="Ttiulo Propiedad" value="<?php echo $titulo; ?>">

                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <img src="/imagenes/<?php echo $imagenPropiedad; ?>" alt="imagen propiedad" class="imagen-small">

                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion"><?php echo $descripcion; ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Información Propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

                <label for="wc">Baños</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedores_id">
                    <option value="">-- Seleccione --</option>
                    <?php while($vendedor = mysqli_fetch_assoc($resultado)): ?>
                        <option <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"><?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Actualizar Propiedad" class="boton-verde">
        </form>
    </main>

<?php 
    incluirTemplate('footer'); 
?>