<?php 

namespace Controllers;

use Model\Proyecto;
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

    public static function crear_proyecto(Router $router) {
        session_start();
        isAuth(); //Protege esta ruta, verifica si esta logueado
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);

            //Validacion 
            $alertas = $proyecto->validarProyecto();

            if (empty($alertas)) {
                //Guardar el Proyecto
            }
        }

        $router->render('dashboard/crear-proyecto', [
            'alertas' => $alertas,
            'titulo' => 'Create Project'
        ]);
    }

    public static function perfil(Router $router) {
        session_start();
        $router->render('dashboard/perfil', [
            'titulo' => 'Profile'
        ]);
    }
}

?>