<?php 
    require '../includes/app.php';
    
    estaAutenticado();

    //importa las clases
    use App\Propiedad;
    use App\Vendedor;

    //Implementar un método para obtener todas las propiedades
    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();

    //Muestra alerta condicional 
    $resultado = $_GET['resultado'] ?? null;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //valida el id al eliminar
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id) {
            //identifica que eliminar (propiedad o vendedor)
            $tipo = $_POST['tipo'];

            if(validarTipoContenido($tipo)) {
                //compara lo que vamos a eliminar
                if($tipo === 'vendedor') {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                } else if($tipo === 'propiedad') {
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            } 
        }
    }

    // Incluye un template 
    incluirTemplate('header');    
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raíces</h1>

        <?php 
            $mensaje = mostrarNotificacion( intval($resultado) );
        ?>
        <?php if($mensaje): ?>
            <p class="alerta exito"><?php echo s($mensaje); ?></p>
        <?php endif; ?>


        <a href="/admin/propiedades/crear.php" class="boton-verde">Nueva Propiedad</a>
        <a href="/admin/vendedores/crear.php" class="boton-amarillo">Nuevo(a) Vendedor</a>

        <h2>Propiedades</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!-- Mostrar los Resultados -->
                <?php foreach($propiedades as $propiedad): ?>
                <tr>
                    <th> <?php echo $propiedad->id; ?> </th>
                    <th> <?php echo $propiedad->titulo; ?> </th>
                    <th> <img src="../imagenes/<?php echo $propiedad->imagen; ?>" alt="imagen propiedad" class="imagen-tabla"> </th>
                    <th>$<?php echo $propiedad->precio; ?></th>
                    <th>
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">
                        </form>
                    </th>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Vendedores</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Télefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!-- Mostrar los Resultados -->
                <?php foreach($vendedores as $vendedor): ?>
                <tr>
                    <th><?php echo $vendedor->id; ?> </th>
                    <th><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></th>
                    <th><?php echo $vendedor->telefono; ?></th>
                    <th>
                        <!--actualiza-->
                        <a href="admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>

                        <!--elimina-->
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">
                        </form>
                    </th>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

<?php 
    //Cerrar la conexión 
    mysqli_close( $db );

    incluirTemplate('footer'); 
?>