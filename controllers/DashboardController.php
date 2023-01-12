<?php 

namespace Controllers;

use MVC\Router;

class DashboardController {
    public static function index (Router $router){

        session_start(); //Iniciamos sesion en el dashboard para traer los datos del usuario
        isAuth();
        
        // Vista del dashboard index
        $router->render('dashboard/index', [
            'titulo' => 'Projects'
        ]);

    }
}

?>