<?php 

    require 'includes/app.php';
    incluirTemplates('header', $inicio = true);    
?>

    
    <main class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono Seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Tempore, officia veritatis magni rerum perferendis asperiores, eius fugiat
                    , assumenda placeat labore illum veniam minima consequuntur porro quis saepe quisquam nemo numquam!
                </p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono Precio" loading="lazy">
                <h3>Precio</h3>
                <p>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Tempore, officia veritatis magni rerum perferendis asperiores, eius fugiat
                    , assumenda placeat labore illum veniam minima consequuntur porro quis saepe quisquam nemo numquam!
                </p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
                <h3>Tiempo</h3>
                <p>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Tempore, officia veritatis magni rerum perferendis asperiores, eius fugiat
                    , assumenda placeat labore illum veniam minima consequuntur porro quis saepe quisquam nemo numquam!
                </p>
            </div>
        </div>
    </main>

    <section class="seccion contenedor">
        <h2>Casas en Venta</h2

        <?php
            include 'includes/templates/anuncios.php';
        ?>

        <div class="alinear-derecha">
            <a href="anuncios.php" class="boton-verde">Ver Todas</a>
        </div>
    </section>

    <section class="imagen-contacto">
        <h2>Encuentra la casa de tus sueños</h2>
        <p>Llena el formulario</p>
        <a href="contacto.php" class="boton-amarillo">Contactános</a>
    </section>

    <div class="contenedor seccion-inferior">
        <section class="blog">
            <h3>Buestro Blog</h3>

            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog1.webp" type="image/webp">
                        <source srcset="build/img/blog1.jpg" type="image/jepg">
                        <img loading="lazy" src="build/img/blog1.jpg" alt="Texto Entrada Blog">
                    </picture>
                </div>

                <div class="texto-entrada">
                    <a href="entrada.php">
                        <h4>Terraza en el Techo de tu casa</h4>
                        <p class="informacion-meta">Escrito el:<span>20/10/2021</span> por: <span>Admin</span></p>

                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, 
                            soluta dolor deleniti ut nisi.

                        </p>
                    </a>
                </div>
            </article> <!-- Fin de article -->
            
            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog2.webp" type="image/webp">
                        <source srcset="build/img/blog2.jpg" type="image/jepg">
                        <img loading="lazy" src="build/img/blog2.jpg" alt="Texto Entrada Blog">
                    </picture>
                </div>

                <div class="texto-entrada">
                    <a href="entrada.php">
                        <h4>Guia para la Decoración de tu Hogar</h4>
                        <p class="informacion-meta">Escrito el:<span>20/10/2021</span> por: <span>Admin</span></p>

                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, 
                            soluta dolor deleniti ut nisi.

                        </p>
                    </a>
                </div>
            </article> <!-- Fin de article -->
        </section> <!-- Fin de Blog -->

        <section class="testimoniales">
            <h3>Testimoniales</h3>

            <div class="testimonial">
                <blockquote>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, 
                    soluta dolor deleniti ut nisi, sit, odit totam error asdasdasdasdasda 
                    adsasdasd
                </blockquote>
                <p>- Jontan Moreno Ramos</p>
            </div>
        </section> <!-- Fin de Testimoniales -->
    </div>

    <?php incluirTemplates('footer'); ?>

</body>
</html>