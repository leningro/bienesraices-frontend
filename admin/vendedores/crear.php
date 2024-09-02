<?php 

    require '../../includes/app.php';

    use App\Vendedor;

    estaAutenticado();

    $vendedor = new Vendedor;

    $errores = Vendedor::getErrores();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //crea una nueva instacia de vendedor 
        $vendedor = new Vendedor($_POST['vendedor']);

        //validar que no haya campos vacios
        $errores = $vendedor->validar();

        if(empty($errores)) {
            $vendedor->guardar();
        }
    }

    incluirTemplate('header');

?>

<main class="contenedor seccion contenido-centrado">
    <h1>Registrar Vendedor(a)</h1>

    <a href="/admin" class="boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <!--El enctype="multipart/form-data" en el <form> sierve para poder recibir subida de archivos--> 
    <form action="/admin/vendedores/crear.php" method="POST" class="formulario">

        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" value="Registrar Vendedor(a)" class="boton-verde">
    </form>
</main>

<?php 
    incluirTemplate('footer'); 
?>