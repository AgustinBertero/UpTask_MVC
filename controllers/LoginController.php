<?php 
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController { //Controlador de authenticacion que tiene cada metodo adentro 
    
    public static function login(Router $router){
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') { //Para el post del Login
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarLogin();

            if (empty($alertas)) {
                //Verificar que el usuario exista
                $usuario = Usuario::where('email', $usuario->email);
            
                if (!$usuario || !$usuario->confirmado ) {
                    Usuario::setAlerta('error', 'The user dont exist or is not confirmed');
               
                } else {
                    //El usuario existe
                    if (password_verify($_POST['password'], $usuario->password)) { // El password es correcto 
                        //Iniciar la sesion 
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionar 
                        header('Location: /proyectos');

                        debuguear($_SESSION);
                    } else {
                        Usuario::setAlerta('error', 'Wrong password');
                    }

                }
            }
    }


        $alertas = Usuario::getAlertas();
        //Render a la vista
        $router->render('auth/login', [ //Muestro la vista de login
            'titulo' => 'Log in',
            'alertas' => $alertas
        ]);  

    }

    public static function logout(){
        echo "Desde logout";

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
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { //Para el post del Login
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if (empty($alertas)) {
                //Buscar el Usuario
                $usuario = Usuario::where('email', $usuario->email);

                if ($usuario && $usuario->confirmado) {
                   //Generar un nuevo Token
                    $usuario->crearToken();
                    unset($usuario->password2);

                   //Actualizar el usuario
                   $usuario->guardar();

                   //Enviar el email 
                   $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                   $email->enviarInstrucciones();


                   //Imprimir la alerta
                   Usuario::setAlerta('exito', 'We have sent the instructions to your email');
                } else {
                    Usuario::setAlerta('error', 'The user does not exist or is not confirmed ');
                    
                }
            }
        }
        //Muestro las alertas
        $alertas = Usuario::getAlertas();

        //Muestra la vista
        $router->render('auth/olvide', [
            'titulo' => 'Forgot my password',
            'alertas' => $alertas
        ]);
    }

    public static function reestablecer(Router $router){

        $token = s($_GET['token']);
        $mostrar = true;


        if (!$token) header('Location: /');

        //Identificar el usuario con este token

        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Invalid Token');
            $mostrar = false;
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') { //Para el post del Login
            //Añadir  nuevo password 
            $usuario->sincronizar($_POST);

            //Validar el password
            $alertas = $usuario->validarPassword();

            if (empty($alertas)) {
                //Hashear el nuevo password
                $usuario->hashPassword();

                //Eliminar el token
                $usuario->token = null;

                //Guardar el usuario en la BD
                $resultado = $usuario->guardar();

                //Redireccionar 
                if ($resultado) {
                    header('Location:/');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        //Muestra la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reset password',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }

    public static function mensaje(Router $router){

        $router->render('auth/mensaje', [
            'titulo' => 'Account successfully created'
        ]);
    }

    public static function confirmar(Router $router){

        $token = s($_GET['token']);

       if (!$token) header('Location: /');

       //Econtrar al usuario con este token
       $usuario = Usuario::where('token', $token);

       if (empty($usuario)) {
        //No se encontro usuario con ese token
            Usuario::setAlerta('error', 'Invalid Token');
       } else {
        //Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->passoword2);

            //Guardar en la BD
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Account successfully verified');
       }

       $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar', [
            'titulo' => 'Confirm your UpTask account'
        ]);
    }

    

}


?>