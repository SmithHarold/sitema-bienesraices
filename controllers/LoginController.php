<?php

namespace Controllers;

use MVC\Router;
use Model\Admin;

class LoginController
{
    public static function login(Router $router) {
        $errores = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST);

            $errores = $auth->validar();
        
        
            if(empty($errores)) {
                // revisar si un usuario existe o no
                $resultado = $auth->existeUsuario();

                if(!$resultado) {
                    $errores = Admin::getErrores();
                } else {
                    //verificar el password
                    $autenticado = $auth->comprobarPassword($resultado);
                    if($autenticado){
                        //autenticar al usuario
                        $auth->autenticar();

                    } else {
                        $errores = Admin::getErrores();
                    }


                }
            
            }
        
        }
        

        $router->render('auth/login', [
            'errores' => $errores
        ]);
    }

    public static function logout() {
        session_start();

        //para que se cierre la sesion se reasigna a la variable un arreglo vacio
        $_SESSION = [];

        header('Location: /');   
    }
}
