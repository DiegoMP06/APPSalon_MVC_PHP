<?php
namespace Model;
use Model\ActiveRecord;
use PHPMailer\PHPMailer\PHPMailer;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    public function validarNuevaCuenta() {
        if (!$this->nombre) {
            self::$alertas['error']['nombre'] = "El Nombre es Obligatorio";
        }
        if (!$this->apellido) {
            self::$alertas['error']['apellido'] = "El Apellido es Obligatorio";
        }
        if (!$this->email) {
            self::$alertas['error']['email'] = "El Email es Obligatorio";
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error']['password'] = "La Contraseña es Debe Tener por lo Menos 6 Caracteres";
        }

        if (!$this->password) {
            self::$alertas['error']['password'] = "La Contraseña es Obligatoria";
        }

        if ((strlen($this->telefono) !== 10) || !preg_match("/[0-9]/", $this->telefono)) {
            self::$alertas['error']['telefono'] = "Formato de Telefono Invalido";
        }

        if (!$this->telefono) {
            self::$alertas['error']['telefono'] = "El Telefono es Obligatorio";
        }

        return self::$alertas;
    }

    public function validarLogin(){
        if (!$this->email) {
            self::$alertas['error']['email'] = "El Email es Obligatorio";
        }
        if (!$this->password) {
            self::$alertas['error']['password'] = "La Contraseña es Obligatoria";
        }

        return self::$alertas;
    }

    public function validarEmail(){
        if (!$this->email) {
            self::$alertas['error']['email'] = "El Email es Obligatorio";
        }
        return self::$alertas;
    }

    public function validarPassword(){

        if (strlen($this->password) < 6) {
            self::$alertas['error']['password'] = "La Contraseña es Debe Tener por lo Menos 6 Caracteres";
        }

        if (!$this->password) {
            self::$alertas['error']['password'] = "La Contraseña es Obligatoria";
        }

        return self::$alertas;
    }

    public function existeUsuario() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . self::$db->escape_string($this->email) . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows){
            self::setAlerta("error", ["usuario" => "El Usuario ya Existe"]);
        }

        return $resultado;
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password){
        $resultado = password_verify($password, $this->password);

        if(!$resultado || !$this->confirmado){
            self::setAlerta("error", ["usuario" => "Contraseña Incorrecta o tu Cuenta no ha sido Confirmada"]);
        }else{
            return true;
        }
    }

}