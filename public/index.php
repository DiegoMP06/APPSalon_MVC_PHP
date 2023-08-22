<?php 

require_once __DIR__ . '/../includes/app.php';

use Controller\AdminController;
use Controller\APIController;
use Controller\CitaController;
use Controller\LoginController;
use Controller\ServicioController;
use MVC\Router;

$router = new Router();

//iniciar Sesion 
$router->get("/", [LoginController::class, "login"]);
$router->post("/", [LoginController::class, "login"]);
$router->get("/logout", [LoginController::class, "logout"]);

// Recuperar Password
$router->get("/olvide", [LoginController::class, "olvide"]);
$router->post("/olvide", [LoginController::class, "olvide"]);
$router->get("/recuperar", [LoginController::class, "recuperar"]);
$router->post("/recuperar", [LoginController::class, "recuperar"]);

// Crear Cuenta
$router->get("/crear-cuenta", [LoginController::class, "crear"]);
$router->post("/crear-cuenta", [LoginController::class, "crear"]);

// Confirmar Cuenta
$router->get("/confirmar-cuenta", [LoginController::class, "confirmar"]);
$router->get("/mensaje", [LoginController::class, "mensaje"]);

// AREA PRIVADA
$router->get("/cita", [CitaController::class, "index"]);
$router->get("/admin", [AdminController::class, "index"]);

// API de Citas
$router->get("/api/servicios", [APIController::class, "index"]);
$router->post("/api/citas", [APIController::class, "guardar"]);
$router->post("/api/eliminar", [APIController::class, "eliminar"]);

// CRUD Servicios
$router->get("/servicios", [ServicioController::class, "index"]);
$router->get("/servicios/crear", [ServicioController::class, "crear"]);
$router->post("/servicios/crear", [ServicioController::class, "crear"]);
$router->get("/servicios/actualizar", [ServicioController::class, "actualizar"]);
$router->post("/servicios/actualizar", [ServicioController::class, "actualizar"]);
$router->post("/servicios/eliminar", [ServicioController::class, "eliminar"]);

$router->comprobarRutas();