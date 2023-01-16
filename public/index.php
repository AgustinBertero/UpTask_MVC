<?php 

//ROUTING

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\DashboardController;
use Controllers\TareaController;

$router = new Router();

// Login = Ruta inicial (/)

$router->get('/',[LoginController::class, 'login']);
$router->post('/',[LoginController::class, 'login']);
$router->get('/logout',[LoginController::class, 'logout']); //Ruta del logout

//Crear cuenta

$router->get('/crear',[LoginController::class, 'crear']); //Get : muestra el form
$router->post('/crear',[LoginController::class, 'crear']); //Post : procesa los datos del form

// Formulario de olvide mi password

$router->get('/olvide',[LoginController::class, 'olvide']); 
$router->post('/olvide',[LoginController::class, 'olvide']); 

// Colocar el nuevo password

$router->get('/reestablecer',[LoginController::class, 'reestablecer']); 
$router->post('/reestablecer',[LoginController::class, 'reestablecer']); 

// Confirmacion de cuenta

$router->get('/mensaje',[LoginController::class, 'mensaje']); 
$router->get('/confirmar',[LoginController::class, 'confirmar']);

//Zona de proyectos
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/crear-proyecto', [DashboardController::class, 'crear_proyecto']);
$router->post('/crear-proyecto', [DashboardController::class, 'crear_proyecto']);
$router->get('/proyecto', [DashboardController::class, 'proyecto']);
$router->get('/perfil', [DashboardController::class, 'perfil']);
$router->post('/perfil', [DashboardController::class, 'perfil']);

//API para las tareas 
$router->get('/api/tareas', [TareaController::class, 'index']);
$router->post('/api/tarea', [TareaController::class, 'crear']);
$router->post('/api/tarea/actualizar', [TareaController::class, 'actualizar']);
$router->post('/api/tarea/eliminar', [TareaController::class, 'eliminar']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();