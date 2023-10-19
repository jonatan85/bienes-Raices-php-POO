<?php 
require '../../includes/app.php';

use App\Vendedor;

// Para que este protegida y solo puedan acceder usuarios autenticados
estaAutenticado();

// Creamos un nuevo vendedor, lo pasamos vacio para que cree un nuevo objeto
$vendedor = new Vendedor;

// Arreglo con mensajes de errores
$errores = Vendedor::getErrores();

// Request method
// Ejecutar el codigo despues de que el usuario envie el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Crear una nueva instacia
    $vendedor = new Vendedor($_POST['vendedor']);
    // debuguear($vendedor);
    // Validar que no haya campos vacios
    $errores = $vendedor->validar();

    // No hay errores
    // Empty verifica que la variable de errores este vacia(sin errores)
    if(empty($errores)) {
        $vendedor->guardar();
    } 

}

incluirTemplates('header');    

?>

<main class="contenedor seccion">
        <h1>Registrar Vendedor(a)</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>    
                                                                                    
        <form class="formulario" method="POST" action="/admin/vendedores/crear.php">
            <?php include '../../includes/templates/formulario_vendedores.php'; ?>

            <input type="submit" value="Registrar Vendedor(a)" class="boton boton-verde">
        </form>
    </main>

    <?php incluirTemplates('footer'); ?>

    <script src="build/js/bundle.min.js"></script>
</body>
</html>