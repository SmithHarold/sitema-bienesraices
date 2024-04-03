<?php include __DIR__ . '/iconos.php'; ?>
<section class="seccion contenedor">
    <h2>Casas y Depas en Venta</h2>
    <?php

    include 'listado.php';
    ?>
    <div class="alinear-derecha">
        <a href="/propiedades" class="boton-verde">Ver Todas</a>
    </div>
</section>

<section class="imagen-contacto">
    <h2>Encuentra la casa de tus sueños</h2>
    <p>Lorem. Nequed, molestias ratione esse expedita labore corrupti, nulla dolore?</p>
    <a href="/contacto" class="boton-amarillo">Contactanos</a>
</section>

<div class="contenedor seccion seccion-inferior">
    <section class="blog">
        <h3>nuestro blog</h3>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog1.webp" type="image/webp">
                    <source srcset="build/img/blog1.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/blog1.jpg" alt="imagen blog">
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="/entrada"></a>
                <h4>terraza enel techo de tu casa</h4>
                <p class="informacion-meta">Edcrito el: <span>11/03/2024</span> por: <span>Admin</span></p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At</p>
            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog2.webp" type="image/webp">
                    <source srcset="build/img/blog2.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/blog2.jpg" alt="imagen blog">
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="/entrada"></a>
                <h4>Guia para la decoracion de tu hogar</h4>
                <p class="informacion-meta">Edcrito el: <span>11/03/2024</span> por: <span>Admin</span></p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At</p>
            </div>
        </article>
    </section>

    <section class="testimoniales">
        <h3>Testimoniales</h3>

        <div class="testimonial">
            <blockquote>
                Lorem non fuga in illum laudantium tempos, aliquid dicta reprehenderit aperiam!
            </blockquote>
            <p>Smith Corales Flores</p>
        </div>
    </section>
</div>