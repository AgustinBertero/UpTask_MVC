<?php 
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController { //Controlador de authenticacion que tiene cada metodo adentro 
    public static function login(Router $router){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { //Para el post del Login
            
        }

        //Render a la vista
        $router->render('auth/login', [ //Muestro la vista de login
            'titulo' => 'Log in'
        ]); 

    }

    public static function logout(){
        echo "Desde login";

    }

    public static function crear(Router $router){
        $alertas = [];
        $usuario = new Usuario;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { //Para el post del Login
                $usuario->sincronizar($_POST);
                $alertas = $usuario->validarNuevaCuenta();
            
                if (empty($alertas)) { //Si alertas esta vacio = Introdujo bien los datos de registro
                    //Comprobamos si el usuario existe
                    $existeUsuario = Usuario::where('email', $usuario->email); 
                    
                    if ($existeUsuario) {
                        Usuario::setAlerta('error', 'User is already registered');
                        $alertas = Usuario::getAlertas();
                    } else { //Si no existe, lo creamos
                        //Hashear el password
                        $usuario->hashPassword();

                        //Eliminar password2
                        unset($usuario->password2);

                        //Generar el token 
                        $usuario->crearToken();

                        //Crear un nuevo usuario
                        $resultado =  $usuario->guardar();

                        //Enviar email de confirmacion
                        $email = new Email($usuario->email, $usuario->nombre, $usuario->token );
                        $email->enviarConfirmacion();

                        if ($resultado) {
                            header('Location: /mensaje');
                        }

                        
                    }
                }

            }

            //Render a la vista
            $router->render('auth/crear', [ //Muestro la vista de crear
                'titulo' => 'Create your account',
                'usuario' => $usuario,
                'alertas' => $alertas
            ]); 

       
    }

    public static function olvide(Router $router){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { //Para el post del Login
            
        }

        //Muestra la vista
        $router->render('auth/olvide', [
            'titulo' => 'Forgot my password'
        ]);
    }

    public static function reestablecer(Router $router){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { //Para el post del Login
            
        }

        //Muestra la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reset password'
        ]);
    }

    public static function mensaje(Router $router){

        $router->render('auth/mensaje', [
            'titulo' => 'Account successfully created'
        ]);
    }

    public static function confirmar(Router $router){
        $router->render('auth/confirmar', [
            'titulo' => 'Confirm your UpTask account'
        ]);
    }

    

}


?>