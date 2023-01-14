<?php 

namespace Controllers;

use JsonException;
use Model\Proyecto;

class TareaController {
    public static function index(){

    }

    public static function crear(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $proyectoId = $_POST['proyectoId'];

            $proyecto = Proyecto::where('url', $proyectoId);

            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) { //Si no hay un proyecto o si no es el propietario
                $respuesta = [
                    'tipo' => 'error', 
                    'mensaje' => 'Error adding task'
                ];
                echo json_encode($respuesta);
            } else { //Existe el proyecto y es el propietario
                $respuesta = [
                    'tipo' => 'exito', 
                    'mensaje' => 'Task successfully added'
                ];
                echo json_encode($respuesta);
            }
        }
    }

    public static function actualizar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
    }

    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
    }

}


?>