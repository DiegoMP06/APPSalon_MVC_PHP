<?php 

namespace Controller;

use Model\Servicio;
use MVC\Router;

class ServicioController{
    public static function index(Router $router) {
        session_start();
        isAdmin();

        $servicios = Servicio::all();

        $router->render("servicios/index", [
            "nombre" => $_SESSION["nombre"],
            "servicios" => $servicios
        ]);
    }
    
    public static function crear(Router $router) {
        session_start();
        isAdmin();

        $servicio = new Servicio;
        $alertas = [];
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
                header("Location: /servicios");
            }
        }

        $router->render("servicios/crear", [
            "nombre" => $_SESSION["nombre"],
            "alertas" => $alertas,
            "servicio" => $servicio
        ]);
    }
    
    public static function actualizar(Router $router) {
        session_start();
        isAdmin();

        $id = $_GET["id"];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        redireccionar404($id);

        $servicio = Servicio::find($id);
        redireccionar404($servicio);

        $alertas = [];
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
                header("Location: /servicios");
            }
        }

        $router->render("servicios/actualizar", [
            "nombre" => $_SESSION["nombre"],
            "alertas" => $alertas,
            "servicio" => $servicio
        ]);
    }
    public static function eliminar() {
        session_start();
        isAdmin();
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $id = $_POST["id"];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            redireccionar404($id);

            $servicio = Servicio::find($id);
            redireccionar404($servicio);

            $servicio->eliminar();
            header("Location: /servicios");
        }
    }
}