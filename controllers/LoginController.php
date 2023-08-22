<?php

namespace Controller;

use Classes\Email;
use MVC\Router;
use Model\Usuario;

class LoginController{
    public static function login(Router $router) : void {
        session_start();
        if(isset($_SESSION["login"])){
            header("Location: /cita");
        }

        $alertas = [];
        $auth = new Usuario;

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $auth->sincronizar($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                $usuario = Usuario::where("email", $auth->email);

                if($usuario){
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        $_SESSION = [];

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        if($usuario->admin === '1'){

                            $_SESSION["admin"] = $usuario->admin ?? null;

                            header("Location: /admin");
                        }else{
                            header("Location: /cita");
                        }

                        debuguear($_SESSION);
                    }
                }else{
                    Usuario::setAlerta("error", ["usuario" => "Usuario No Encontrado"]);
                }
            }
        }
        
        $alertas = Usuario::getAlertas();

        $router->render("auth/login", [
            "alertas" => $alertas,
            "auth" => $auth
        ]);
    }

    public static function logout() : void {
        session_start();
        $_SESSION = [];
        header("Location: /");
    }
    
    public static function olvide(Router $router) : void {

        $alertas = [];
        $auth = new Usuario;

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $auth->sincronizar($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where("email", $auth->email);

                if($usuario && $usuario->confirmado === "1"){
                    $usuario->crearToken();
                    
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();
                    
                    $resultado = $usuario->guardar();
                    $resultado ? Usuario::setAlerta("exito", ["usuario" => "Revisa tu Email"]) : "";

                }else{
                    Usuario::setAlerta("error", ["usuario" => "El Usuario no Existe o no Esta Confirmado"]);
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/olvide-password", [
            "alertas" => $alertas
        ]);
    }
    
    public static function recuperar(Router $router) : void {
        
        $alertas = [];
        $error = false;
        $auth = new Usuario;

        $token = sanitizar($_GET["token"]);
        $usuario = Usuario::where("token", $token);

        if(empty($usuario)){
            Usuario::setAlerta("error", ["token" => "Token No Valido"]);
            $error = true;
        }

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $auth->sincronizar($_POST);
            $alertas = $auth->validarPassword();

            if(empty($alertas)){
                $usuario->password = null;
                $usuario->password = $auth->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();

                if($resultado){
                    header("Location: /");
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render("auth/recuperar-password", [
            "alertas" => $alertas,
            "error" => $error
        ]);
    }

    public static function crear(Router $router) : void {

        $usuario = new Usuario;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->validarNuevaCuenta();

            if(empty($alertas)){
                $resultado = $usuario->existeUsuario();
                $alertas = Usuario::getAlertas();

                if(!$resultado->num_rows){
                    $usuario->hashPassword();
                    $usuario->crearToken();
                    
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();
                    
                    
                    $resultado = $usuario->guardar();
                    if($resultado){
                        header("Location: /mensaje");
                    }
                }
            }
        }


        $router->render("auth/crear-cuenta", [
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }

    public static function mensaje(Router $router) : void {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router) : void {    
        $alertas = [];

        $token = sanitizar($_GET['token']);
        $usuario = Usuario::where("token", $token);

        if(empty($usuario)){
            Usuario::setAlerta("error", ["token" => "Token No Valido"]);
        }else{
            $usuario->confirmado = 1;
            $usuario->token = null;
            $usuario->guardar();

            Usuario::setAlerta("exito", ["token" => "Cuenta Confirmada con exito"]);
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/confirmar-cuenta", [
            "alertas" => $alertas        
        ]);
    }
}