<?php 
    //Importar la conexión a la BD
    require '../includes/config/database.php';
    $db = conectarDB();

    //Escribir el query
    $query = "SELECT * FROM propiedades";

    //Consultar la BD
    $resultadoConsulta = mysqli_query($db, $query);

    //Muestra alerta condicional 
    $resultado = $_GET['resultado'] ?? null;

    // Incluye un template 
    require '../includes/funciones.php';
    incluirTemplate('header');    
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raíces</h1>

        <?php if( intval( $resultado ) === 1 ): ?>
            <p class="alerta exito">Anuncio Creado Correctamente</p>
        <?php elseif( intval( $resultado ) === 2 ): ?>
            <p class="alerta exito">Anuncio Actualizado Correctamente</p>
        <?php endif; ?>

        <a href="/admin/propiedades/crear.php" class="boton-verde">Nueva Propiedad</a>

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
                <?php while( $propiedad = mysqli_fetch_assoc( $resultadoConsulta ) ): ?>
                <tr>
                    <th> <?php echo $propiedad['id']; ?> </th>
                    <th> <?php echo $propiedad['titulo']; ?> </th>
                    <th> <img src="../imagenes/<?php echo $propiedad['imagen']; ?>" alt="imagen propiedad" class="imagen-tabla"> </th>
                    <th>$<?php echo $propiedad['precio']; ?></th>
                    <th>
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">Actualizar</a>
                        <a href="#" class="boton-rojo-block">Eliminar</a>
                    </th>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

<?php 
    //Cerrar la conexión 
    mysqli_close( $db );

    incluirTemplate('footer'); 
?>