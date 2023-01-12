<?php 

namespace Controllers;

use MVC\Router;

class DashboardController {
    public static function index (Router $router){



        // Vista del dashboard index
        $router->render('dashboard/index', [

        ]);

    }
}

?>