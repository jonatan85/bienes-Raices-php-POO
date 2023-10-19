<?php

    define('TEMPLATES_URL', __DIR__ . '/templates');
    define('FUNCUINES_URL', __DIR__ . 'funciones.php');
    define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');
    
    function incluirTemplates( string $nombre, bool $inicio = false) {
        include TEMPLATES_URL . "/$nombre.php";
    }

    function estaAutenticado() {
        session_start();

        if(!$_SESSION['login']) {
            header('Location: /');
        }
    }

    function debuguear($variable) {
        echo "<pre>";
        var_dump($variable);
        echo "</pre>";
        exit;
    }

    // Escapa / Sanitizar el HTML
    function s($html) : string {
        $s = htmlspecialchars($html);
        return $s;
    }

    // Validar tipo de contenido
    function validarTipoContenido($tipo) {
        $tipos = ['vendedor', 'propiedad'];
        // In_array busca un string dentro de un arreglo o un valor(numero)
        // Toma dos valores, primero lo que vamos a buscar y segundo el arreglo donde lo va a buscar
        return in_array($tipo, $tipos);
    }

    // Muestra los mensajes
    function mostrarNotificaciones($codigo) {
        $mensaje = '';

        switch($codigo) {
            case 1:
                $mensaje = 'Creado Correctamente';
                break;

            case 2:
                $mensaje = 'Actualizado correctamente';
                break;

            case 3:
                $mensaje = 'Eliminado correctamente';
                break;
                
            default:
                $mensaje = false;
                break;
        }

        return $mensaje;
    }