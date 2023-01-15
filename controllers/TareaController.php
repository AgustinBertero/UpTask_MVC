<?php 

namespace Controllers;

use JsonException;
use Model\Proyecto;
use Model\Tarea;

class TareaController {
    public static function index(){

            $proyectoId = $_GET['id'];

            if (!$proyectoId) header('Location : /');

            $proyecto = Proyecto::where('url', $proyectoId);
            
        session_start();

            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) header('Location: /404');

        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);

        echo json_encode(['tareas' => $tareas]); //Creo un JSON con las tareas del proyecto
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
                return;
            }

        //Todo bien, instanciar y crear la tarea
        //Existe el proyecto y es el propietario
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Task successfully created',
                'proyecotId' => $proyecto->id
            ];
            echo json_encode($respuesta);
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