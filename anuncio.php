<?php 
    //Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    //si la URL no tiene un id valido lo redirecciona
    if(!$id) {
        header('Location: /');
    }
    
    //base de datos
    require 'includes/config/database.php';
    $db = conectarDB();
    
    //consultar/hacer el query
    $query = "SELECT * FROM propiedades WHERE id = {$id}";

    //obtenemos el resultado de la consulta 
    $resultado = mysqli_query($db, $query);

    // echo "<pre>";
    // var_dump($resultado);
    // echo "</pre>";

    /*
    El $resultado no es un arreglo, es de tipo OBJECT 
    que tiene que ver con programación orientada a objetos 
    Podemos comprobar si hubo resultados si su num_rows = 1 ó = 0
    en un arreglo asociativo es $resultado['num_rows'] (NO es el caso)
    en un objeto (como es el caso) es $resultado->num_rows;
    */

    if(!$resultado->num_rows) { //if($resultado->num_rows === 0){}
        header('Location: /');
    }

    //obtenemos la propiedad
    $propiedad = mysqli_fetch_assoc($resultado);

    // echo "<pre>";
    // var_dump($propiedad);
    // echo "</pre>";

    require 'includes/funciones.php';
    incluirTemplate('header');    
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Casa en Venta Frente al Bosque</h1>

        <img loading="lazy" src="imagenes/<?php echo $propiedad['imagen']; ?>" alt="Imagen Destacada">

        <div class="resumen-propiedad">
            <p class="precio">$<?php echo $propiedad['precio']; ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad['wc']; ?></p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad['estacionamiento']; ?></p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad['habitaciones']; ?></p>
                </li>
            </ul>

            <p><?php echo $propiedad['descripcion']; ?></p>
        </div>
    </main>

<?php 
    incluirTemplate('footer'); 
?>