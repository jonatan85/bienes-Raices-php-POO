<?php 
    require 'includes/app.php';

    use App\Propiedad;

    // Para traer el anuncio con el id aplicamos un filtro.
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    
    if(!$id) {
        header('Location: /');
    }

    $propiedad = Propiedad::find($id);
    
    incluirTemplates('header');    
?>    
    <main class="contenedor seccion contenido-centrado ">
        <h1><?php echo $propiedad->titulo; ?></h1>

        <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="imagen">


        <div class="resumen-propiedad">
        <p class="precio"><?php echo $propiedad->precio; ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad->habitaciones; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad->wc; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad->estacionamiento; ?></p>
                </li>

            </ul>

            <p><?php echo $propiedad->descripcion; ?></p>

        </div>
    </main>

    <?php
        mysqli_close($db);
        
        incluirTemplates('footer'); 
    ?>

</body>
</html>
