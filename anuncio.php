<?php 
    require 'includes/funciones.php';
    incluirTemplate('header');    
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Casa en Venta Frente al Bosque</h1>

        <picture>
            <source srcset="build/img/destacada.webp" type="image/webp">
            <img loading="lazy" src="build/img/destacada.jpg" alt="Imagen Destacada">
        </picture>

        <div class="resumen-propiedad">
            <p class="precio">$3,000,000</p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" src="build/img/icono_wc.svg" alt="icono wc">
                    <p>3</p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p>3</p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p>4</p>
                </li>
            </ul>

            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Temporibus voluptatum veniam, veritatis hic reiciendis totam corporis doloremque expedita beatae nam cupiditate earum eum, repellat architecto nulla facere suscipit dolores delectus omnis iste. Laboriosam, laborum. Aut, dolore repudiandae. Pariatur deleniti assumenda esse officiis quidem inventore voluptatibus unde harum nemo doloribus. Ex quos error ad tenetur ullam rem quia animi velit, illum harum eaque voluptate tempore nemo! Quos adipisci cupiditate corrupti officiis nisi quo ducimus officia rerum ea in porro dicta assumenda nulla molestias esse, sapiente eaque a debitis omnis ratione atque? Odit repudiandae quidem optio repellendus obcaecati temporibus eligendi repellat ipsum.</p>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas natus, totam omnis veniam numquam autem voluptates dolor dolorem hic ipsa architecto maxime illum in suscipit sint dicta itaque exercitationem. Ipsam eaque esse, molestiae distinctio nulla labore! Non sequi corporis modi eius sapiente beatae, eveniet architecto harum ullam laudantium, ipsam aperiam!</p>
        </div>
    </main>

<?php 
    incluirTemplate('footer'); 
?>