<?php

    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    require '../../includes/app.php';
    estaAutenticado();
    
    // VALIDAR QUE EL ID SEA UN ID VALIDO
    // Obtener el id que hemos enviado desde el index con el boton actualizar
    $id = $_GET['id'];
    // Validamos el id para que nadie le pase una cadena de texto o otro valor
    $id = filter_var($id, FILTER_VALIDATE_INT);

    // Si intenta añadir un valor que no sea un id les redirigimos a admin
    if(!$id) {
        header('Location: /admin');
    }

    // Obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);

    // Consulta para obtener todos los vendedores
    $vendedores = Vendedor::all();

    // Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

    // Ejecutar el codigo despues de que el usuario envie el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Asignar los atributos
        $args = $_POST['propiedad'];
    
        $propiedad->sincronizar($args);

        // Validacion 
        $errores = $propiedad->validar();

        // Subida de archivos
        // Generar un nombre unico para cada imagen, este genera un numero aleatorio para nombrar un archivo con un nombre diferente cada vez que subamos una imagen
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";
        // Setear la imagen 
        if($_FILES['propiedad']['tmp_name']['imagen']) {
            // Forma de realizar un resize a la imagen con intervencion con Poo
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            // Seteamos el nombre unico de la imagen no el archivo
            $propiedad->setImagen($nombreImagen);
        }

        // Revisar que el array de errores este vacio
        if(empty($errores)) {
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                // Almacenar la imagen
                $image->save(CARPETA_IMAGENES . $nombreImagen );
            }

            $propiedad->guardar();
        }
    }

    incluirTemplates('header');    
?>    
    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>    
                                                                                    <!--enctype="multipart/form-data"(2)  -->
        <form class="formulario" method="POST"  enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php'; ?>

            <input type="submit" value="Actulizar Propiedad" class="boton boton-verde">
        </form>
    </main>

    <?php incluirTemplates('footer'); ?>

    <script src="build/js/bundle.min.js"></script>
</body>
</html>


<!--(1) mysqli_real_escape_string es una función en PHP que se utiliza para escapar (o "limpiar") las cadenas de texto que se van a insertar en una consulta SQL antes de ejecutarla en una base de datos MySQL. Su función principal es prevenir la inyección de SQL, que es un tipo de ataque en el que un atacante intenta manipular una consulta SQL para acceder o alterar datos en la base de datos de manera no autorizada.

La función mysqli_real_escape_string toma dos argumentos:

La conexión a la base de datos MySQL a través de la extensión mysqli.
La cadena de texto que se desea escapar.
La función devuelve la cadena de texto escapada, que se puede usar de manera segura en una consulta SQL sin el riesgo de introducir código malicioso. -->

<!-- (2) La propiedad enctype con el valor "multipart/form-data" es un atributo de un formulario HTML utilizado para especificar cómo se codificará el contenido de un formulario antes de ser enviado al servidor web. Es especialmente importante cuando se envían archivos binarios, como imágenes o archivos de video, a través de un formulario.

Cuando un formulario tiene enctype="multipart/form-data", significa que el navegador web codificará los datos del formulario y los archivos adjuntos de una manera especial, conocida como codificación multiparte (multipart encoding). Esto es necesario porque los archivos adjuntos pueden contener datos binarios y, por lo tanto, no pueden codificarse de la misma manera que los datos de texto simple. -->

<!-- (3) is_dir es una función en PHP que se utiliza para comprobar si una ruta especificada corresponde a un directorio en el sistema de archivos del servidor. La función devuelve true si la ruta es un directorio válido y existe, y false si no lo es o si ocurre algún error. -->

<!-- (4) 
move_uploaded_file es una función en PHP que se utiliza para mover un archivo cargado (subido) desde una ubicación temporal (donde se almacena inicialmente después de cargarse desde un formulario HTML) a una ubicación permanente en el servidor de archivos. Esta función es comúnmente utilizada cuando se trabaja con formularios web que permiten a los usuarios cargar archivos, como imágenes, documentos, archivos de audio, etc. -->
