<?php 

    require '../../includes/app.php';
    use App\Vendedor;
    estaAutenticado();

    //validar que la url tenga un id válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
    }

    //obtener el arreglo assoc del vendedor
    $vendedor = Vendedor::find($id);

    //arreglo con mensajes de errores
    $errores = Vendedor::getErrores();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //asignar los valores previos a una variable
        $args = $_POST['vendedor'];

        //sincronizar objeto en memoria con lo que el usuario escribio
        $vendedor->sincronizar($args);

        //validación de la actualización
        $errores = $vendedor->validar();
        
        if(empty($errores)) {
            $vendedor->guardar();
        }
    }

    incluirTemplate('header');

?>

<main class="contenedor seccion contenido-centrado">
    <h1>Actualizar Vendedor(a)</h1>

    <a href="/admin" class="boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <!--El enctype="multipart/form-data" en el <form> sierve para poder recibir subida de archivos--> 
    <form action="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" method="POST" class="formulario">

        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" value="Guardar Cambios" class="boton-verde">
    </form>
</main>

<?php 
    incluirTemplate('footer'); 
?>