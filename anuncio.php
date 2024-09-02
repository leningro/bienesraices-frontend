<?php

    require 'includes/app.php';

    use App\Propiedad;

    //Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    //si la URL no tiene un id valido lo redirecciona
    if(!$id) {
        header('Location: /');
    }

    $propiedad = Propiedad::find($id);
    

    incluirTemplate('header');    
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Casa en Venta Frente al Bosque</h1>

        <img loading="lazy" src="imagenes/<?php echo $propiedad->imagen; ?>" alt="Imagen Destacada">

        <div class="resumen-propiedad">
            <p class="precio">$<?php echo $propiedad->precio; ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad->wc; ?></p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad->estacionamiento; ?></p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad->habitaciones; ?></p>
                </li>
            </ul>

            <p><?php echo $propiedad->descripcion; ?></p>
        </div>
    </main>

<?php 
    incluirTemplate('footer'); 
?>