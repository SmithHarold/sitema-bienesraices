<?php

    use App\Propiedad;

    
    if($_SERVER['SCRIPT_NAME'] === '/bienesraices/anuncios.php') {
        $propiedades = Propiedad::all();
    } else {
        $propiedades = Propiedad::get(3);
    }

?>

<div class="contenedor-anuncios">
    <?php foreach($propiedades as $propiedad) { ?>
    <div class="anuncio">
        <picture>
            <!-- loading lazy sirve para que el archivo cargue solo cuando se va a utilizar -->
            <img loading="lazy" src="/bienesraices/imagenes/<?php echo $propiedad->imagen; ?>" alt="anuncio">
        </picture>

        <div class="contenido-anuncio">
            <h3><?php echo $propiedad->titulo; ?></h3>
            <p><?php echo $propiedad->descripcion; ?></p>
            <p class="precio"><?php echo $propiedad->precio; ?></p>

            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono">
                    <p><?php echo $propiedad->wc; ?></p>
                </li>

                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="estacionamiento">
                    <p><?php echo $propiedad->estacionamiento; ?></p>
                </li>

                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="dormitorio">
                    <p><?php echo $propiedad->habitaciones; ?></p>
                </li>
            </ul>

            <a class="boton-amarillo-block" href="anuncio.php?id=<?php echo $propiedad->id; ?>">Ver Propiedad</a>
        </div> <!-- fin contenido anuncio -->
        
    </div> <!-- fin anuncio -->
    <?php }; ?>
</div>
        