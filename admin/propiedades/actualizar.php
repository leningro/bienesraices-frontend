<?php

    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManager as Image;
    use Intervention\Image\Drivers\Gd\Driver;

    require '../../includes/app.php';
    
    estaAutenticado();

    //Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    //si la URL no tiene un id valido lo redirecciona
    if(!$id) {
        header('Location: /admin');
    }

    //obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);

    $vendedores = Vendedor::all();

    //Arreglo con los mensajes de errores
    $errores = Propiedad::getErrores();

    //Almacenar en variables los inputs al enviar el formulario con metodo POST
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $args = $_POST['propiedad'];
        $propiedad->sincronizar($args);

        $errores = $propiedad->validar();

        //Genera un nombre unico 
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $manager = new Image(Driver::class);
            $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800,600);  
            $propiedad->setImagen($nombreImagen);
        }

        
        //Revisar que el array del errores este vacio 
        if(empty($errores)) {
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $image->save(CARPETA_IMAGENES . $nombreImagen);
            }
            $propiedad->guardar();
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
            
            <?php include '../../includes/templates/formulario_propiedades.php'; ?>

            <input type="submit" value="Actualizar Propiedad" class="boton-verde">
        </form>
    </main>

<?php 
    incluirTemplate('footer'); 
?>