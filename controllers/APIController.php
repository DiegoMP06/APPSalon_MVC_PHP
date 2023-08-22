<?php 
namespace Controller;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{
    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar(){

        // Almacena la CIta y Devuelve el Id
        $cita = new Cita($_POST); 
        $resultado = $cita->guardar();
        $citaId = $resultado["id"];

        // Almacena la Cita y Servicio
        $idServicios = explode(",", $_POST["servicios"]);

        foreach($idServicios as $idServicio){
            $args = [
                "citaId" => $citaId,
                "servicioId" => $idServicio
            ];

            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        echo json_encode($resultado);
    }

    public static function eliminar(){
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $id = $_POST["id"];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            redireccionar404($id);

            $cita = Cita::find($id);
            redireccionar404($cita);

            $cita->eliminar();
            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    }
}
