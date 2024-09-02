<?php 
    require '../../includes/app.php';

    use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManager as Image;
    use Intervention\Image\Drivers\Gd\Driver;

    estaAutenticado();

    $propiedad = new Propiedad();

    //consulta para obtener los vendedores
    $vendedores = Vendedor::all();

    // debuguear($vendedores);

    //Arreglo con los mensajes de errores
    $errores = Propiedad::getErrores();

    //Almacenar en variables los inputs al enviar el formulario con metodo POST
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $propiedad = new Propiedad($_POST['propiedad']);

        //Genera un nombre unico 
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $manager = new Image(Driver::class);
            $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800,600);  
            $propiedad->setImagen($nombreImagen);
        }

        $errores = $propiedad->validar();

        //Revisar que el array del errores este vacio 
        if(empty($errores)) {

            //comprueba si ya existe la ruta 
            if(!is_dir(CARPETA_IMAGENES)) {
                //como no existe crea el directorio/carpeta
                mkdir(CARPETA_IMAGENES);
            }

            $image->save(CARPETA_IMAGENES . $nombreImagen);

            $propiedad->guardar();
        }

    }

    //template del header
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

            <?php include '../../includes/templates/formulario_propiedades.php'; ?>

            <input type="submit" value="Crear Propiedad" class="boton-verde">
        </form>
    </main>

<?php 
    incluirTemplate('footer'); 
?>