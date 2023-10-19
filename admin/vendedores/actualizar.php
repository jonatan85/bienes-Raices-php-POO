<?php 
require '../../includes/app.php';
use App\Vendedor;
// Para que este protegida y solo puedan acceder usuarios autenticados
estaAutenticado();

// Validar que sea un ID válido
$id = $_GET['id'];
// La función de php filter_var verifica que el id sea valido primero pasandole el id + FILTER_VALIDATE_INT
$id = filter_var($id, FILTER_VALIDATE_INT);
// En caso de que se intente acceder si un id se redirige 
if(!$id) {
    header('Location: /admin');
}

// Para obtener los datos de el vendedor
// Accedemos a la función de Active recors find 
$vendedor = Vendedor::find($id);

// Arreglo con mensajes de errores
$errores = Vendedor::getErrores();

// Request method
// Ejecutar el codigo despues de que el usuario envie el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asignar los valores
    $args = $_POST['vendedor'];
    
    // Sincronizarel objeto en memoria con lo que el usuario escribió
    $vendedor->sincronizar($args);

    // Validacion 
    $errores = $vendedor->validar();
    // debuguear($errores);

    // Guardar
    if(empty($errores)) {
        $vendedor->guardar();
    }
}

incluirTemplates('header');    

?>

<main class="contenedor seccion">
        <h1>Actualizar Vendedor(a)</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>    
                                                                                    
        <form class="formulario" method="POST">
            <?php include '../../includes/templates/formulario_vendedores.php'; ?>

            <input type="submit" value="Guardar Cambios" class="boton boton-verde">
        </form>
    </main>

    <?php incluirTemplates('footer'); ?>

    <script src="build/js/bundle.min.js"></script>
</body>
</html>