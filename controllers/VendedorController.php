<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;


class VendedorController
{


    public static function crear(Router $router)
    {
        // arreglo con mensajes de errores
        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor;



        // almacenar en la BD
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vendedor = new Vendedor($_POST['vendedor']);

            $errores = $vendedor->validar();

            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router)
    {
        $errores = Vendedor::getErrores();

        $id = validaroRedireccionar('/admin');

        $vendedor = Vendedor::find($id);

        //ejecutar el codigo despues de que el usuario envia el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // asigna los valores
            $args = $_POST['vendedor'];

            // sincriniza objeto en memoria con lo que el usuario escribio
            $vendedor->sincronizar($args);

            // debugear($vendedor); 
            // validacion
            $errores = $vendedor->validar();

            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //validar ID
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {

                $tipo = $_POST['tipo'];

                if (validarTipoContenido($tipo)) {
                    //compara lo que vamos a eliminar
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}
