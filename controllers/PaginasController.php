<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{
    public static function index(Router $router)
    {
        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio

        ]);
    }

    public static function nosotros(Router $router)
    {

        $router->render('paginas/nosotros');
    }

    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades

        ]);
    }

    public static function propiedad(Router $router)
    {
        // $propiedades = Propiedad::get();
        $id = validaroRedireccionar('/propiedades');

        $propiedad = Propiedad::find($id);


        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad


        ]);
    }

    public static function blog(Router $router)
    {
        $router->render('paginas/blog');
    }

    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada');
    }

    public static function contacto(Router $router)
    {
        $mensaje = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            
            $respuestas = $_POST['contacto'];

            //crear nueva instancia de phpmailer
            $mail = new PHPMailer();

            //configurar el SMTP (protocolo para el envio de emails)
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;//para autenticarse
            $mail->Username = '27e1de407bff74';
            $mail->Password = '3b8b9ed78f7159';
            $mail->SMTPSecure = 'tls';//protocolo de cifrado de la informacion
            $mail->Port = 2525;

            //configuarar el conternido del email
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BinesRaices.com');
            $mail->Subject = 'tienes un Nuevo Mensaje de corazón';

            //habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            //definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>'; 
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . ' </p>';

            // Enviar de forma condicional algunos campos de email o teléfono
            if($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p>Telefono: ' . $respuestas['telefono'] . ' </p>'; 
                $contenido .= '<p>Fecha: ' . $respuestas['fecha'] . ' </p>'; 
                $contenido .= '<p>Hora: ' . $respuestas['hora'] . ' </p>'; 
            } else {
                $contenido .= '<p>Eligió se contactado por email: </p>'; 
                $contenido .= '<p>Email: ' . $respuestas['email'] . ' </p>'; 
            }

            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . ' </p>'; 
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo'] . ' </p>'; 
            $contenido .= '<p>Precio o Presupuesto: $' . $respuestas['precio'] . ' </p>'; 
            $contenido .= '<p>Prefiere ser contactado por: ' . $respuestas['contacto'] . ' </p>'; 
            
            $contenido .= '</html>';

            //Habilitar el contenido
            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML';


            if($mail->send()) {
                $mensaje = "El mensaje se envio correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar...";
            }
        }
        $router->render('paginas/contacto', [
            'mensaje' => $mensaje


        ]);
    }
}
