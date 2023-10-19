<?php

    require '../includes/app.php';
    estaAutenticado();

    // Importar la clases
    use App\Propiedad;
    use App\Vendedor;


    // Implementar un metodo para obtener todas las propiedades utilizando active record
    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();
    
    // Muestra un mensaje condicional
    $resultado = $_GET['resultado'] ?? null;

    // Eliminar 
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        
        if($id) {

            $tipo = $_POST['tipo'];

            // Le pasamos la funcion con el tipo que vamos a validar
            if(validarTipoContenido($tipo)) {
                // Compara lo que vamos a elminar
                if($tipo === 'vendedor') {
                    // Obtenemos los datos de Vendedor con un metodo de find
                    $propiedad = Vendedor::find($id);
                    $propiedad->eliminar();
                } else if ($tipo === 'propiedad') {
                    // Obtenemos los datos de la Propiedad con un metodo de find
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            } 
        }
    }

    // Incluye un template
    
    incluirTemplates('header');    
?>    
    <main class="contenedor seccion">
        <h1>Administrador de Vienes Raices</h1>
        
        <?php
            //                          Usamos intval para transformar un string en un entero
            $mensaje = mostrarNotificaciones( intval($resultado) );
            if($mensaje) { ?>
                <p class="alerta exito"> <?php echo s($mensaje) ?></p>   
        <?php } ?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
        <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo Vendedor</a>
    </main>

    <h2>Propiedades</h2>
    
    <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- Mostrar los resultados -->
                <?php foreach( $propiedades as $propiedad ): ?>
                <tr>
                    <td> <?php echo $propiedad->id; ?> </td>
                    <td> <?php echo $propiedad->titulo; ?> </td>
                    <td><img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="casa en la playa" class="imagen-tabla"></td>
                    <td> <?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a class="boton-amarillo-block" href="admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
    </table>

    <h2>Vendedores</h2>

    <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- Mostrar los resultados -->
                <?php foreach( $vendedores as $vendedor ): ?>
                <tr>
                    <td> <?php echo $vendedor->id; ?> </td>
                    <td> <?php echo $vendedor->nombre . " " . $vendedor->apellido; ?> </td>
                    <td> <?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a class="boton-amarillo-block" href="admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
    </table>

    
    
    <?php 
        // Cerrar la conexion
        mysqli_close($db);       
        
        incluirTemplates('footer'); 
    
    ?>

</body>
</html>