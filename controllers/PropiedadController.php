<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

class PropiedadController
{
    public static function index(Router $router)
    {

        $propiedades = Propiedad::all();

        $vendedores = Vendedor::all();

        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores,
        ]);
    }

    public static function crear(Router $router)
    {
        // arreglo con mensajes de errores
        $errores = Propiedad::getErrores();
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();



        // almacenar en la BD
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //crear una nueva instancia
            $propiedad = new Propiedad($_POST['propiedad']);

            //Generar un nombre unico a la imagen
            $bytesAleatorios = random_bytes(16); // 16 bytes = 128 bits
            $nombreImagen = bin2hex($bytesAleatorios) . ".jpg";

            // resize en la imagen con intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);

                $propiedad->setImagen($nombreImagen);
            }


            $errores = $propiedad->validar();

            if (empty($errores)) {
                // crear carpeta para subir imagenes
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                //Guardar la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                //GURDA LA IMAGEN EN LA BD
                $propiedad->guardar();
            }
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router)
    {
        $id = validaroRedireccionar('/admin');

        $propiedad = Propiedad::find($id);

        $vendedores = Vendedor::all();

        $errores = Propiedad::getErrores();

        //ejecutar el codigo despues de que el usuario envia el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //asignar los atributos
            $args = $_POST['propiedad'];

            $propiedad->sincronizar($args);

            //validacion 
            $errores = $propiedad->validar();

            //Generar un nombre unico a la imagen

            $bytesAleatorios = random_bytes(16); // 16 bytes = 128 bits
            $nombreImagen = bin2hex($bytesAleatorios) . ".jpg";


            // subida de archivos
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
                $propiedad->setImagen($nombreImagen);
            }

            //revisar que el array de errores este vacio
            if (empty($errores)) {

                //almacenar la imagen
                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }

                $propiedad->guardar();
            }
        }

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
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
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}
