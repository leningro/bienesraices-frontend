<?php 
    //base de datos
    require '../../includes/config/database.php';
    $db = conectarDB();

    //Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db,$consulta);

    //Arreglo con los mensajes de errores
    $errores = [];

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedores_id = '';

    //Almacenar en variables los inputs al enviar el formulario con metodo POST
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //Esto es par ver en pantalla los datos del POST que se enviaron en el formulario
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        // echo "<pre>";
        // var_dump($_FILES);
        // echo "</pre>";


        //mysqli_real_escape_string() -> sanitiza los datos de los input para que no haya intección SQL o algo similar 
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
        if(!$imagen['name']) {
            $errores[] = "La imagen es obligatoria";
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

            //Genera un nombre unico 
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

            //mueve archivos de una ruta a otra. En este caso la ruta temporal a la ruta de nuestra carpeta 
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );


            /* INSERTANDO EN LA BASE DE DATOS */
            $query = " INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id) VALUES ('$titulo','$precio','$nombreImagen','$descripcion','$habitaciones','$wc','$estacionamiento','$creado','$vendedores_id') ";

            //El $resultado da true o false si el query se realizo correctamente en la $db
            $resultado = mysqli_query($db, $query);

            if($resultado) {
                //Redireccionar al usuario 

                //query string -> url con algunos parametros
                header('Location: /admin?resultado=1');
            }
        }

    }

    //template del header
    require '../../includes/funciones.php';
    incluirTemplate('header');    
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Crear</h1>

        <a href="/admin" class="boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <!--El enctype="multipart/form-data" en el <form> sierve para poder recibir subida de archivos--> 
        <form action="/admin/propiedades/crear.php" method="POST" class="formulario" enctype="multipart/form-data">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo</label>
                <input type="text" id="titulo" name="titulo" placeholder="Ttiulo Propiedad" value="<?php echo $titulo; ?>">

                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

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

            <input type="submit" value="Crear Propiedad" class="boton-verde">
        </form>
    </main>

<?php 
    incluirTemplate('footer'); 
?>