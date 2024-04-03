<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');

// define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate ( string $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado() : bool {
    session_start();

    if(!$_SESSION['login']) {
        header('Location: /bienesraices/index.php');
    }

    return false;
}

function debugear($variable) {
    
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";

    exit;
}

// escapa / sanitiza el html antes que se ingrese a la bd cuando el usuario escribe y aun no se valida

function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function validarTipoContenido($tipo) {
    $tipos = ['vendedor', 'propiedad'];
     return in_array($tipo, $tipos);
}

// mostrar los mensajes

function mostrarNotificacion($codigo) {
    $mensaje = '';

    switch($codigo) {
        case 1:
            $mensaje = 'Creado correctamente';
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

function validaroRedireccionar(string $url) {
    
    // validar un id como entero
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    
    if(!$id) {
        header('Location: ${url}');
    }
    return $id;
}