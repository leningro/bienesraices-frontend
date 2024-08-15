<?php include 'includes/templates/header.php' ?>

    <main class="contenedor seccion">
        <h1>Conoce sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <img loading="lazy" src="build/img/nosotros.jpg" alt="Sobre Nosotros">
                </picture>
            </div>

            <div class="texto-nosotros">
                <blockquote>
                    25 años de experiencia
                </blockquote>

                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Inventore consectetur maiores placeat dolorem reprehenderit accusantium odit? Consequatur officiis harum necessitatibus molestias tempora, doloremque cum adipisci optio et explicabo sunt asperiores sint unde! Iure deleniti aliquid omnis est modi accusantium provident nulla suscipit atque? Fugit eligendi officiis vel animi, vitae deleniti?</p>

                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolor quo qui, voluptatum voluptatibus aliquam deserunt perferendis dolorem maiores repellat consequuntur.</p>
            </div>
        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>
        
        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono Seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, a similique ipsa eum suscipit minima.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono Precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, a similique ipsa eum suscipit minima.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
                <h3>A Tiempo</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, a similique ipsa eum suscipit minima.</p>
            </div>
        </div>
    </section>

<?php 
    include 'includes/templates/footer.php';    
?>