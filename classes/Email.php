<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $nombre;
    public $email;
    public $token;

    public function __construct($nombre, $email, $token){
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV["EMAIL_HOST"];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV["EMAIL_PORT"];
        $mail->Username = $_ENV["EMAIL_USER"];
        $mail->Password = $_ENV["EMAIL_PASS"];

        $mail->setFrom("cuenta@appsalon.com");
        $mail->addAddress("cuenta@appsalon.com", "APPSalon.com");
        $mail->Subject = "Confirma Tu Cuenta de APPSalon.com";

        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre . "</strong> Has Creado tu Cuenta en APPSalon.com, Solo Debes Confirmarla Presionando el Siguiente Enlace:</p>";
        $contenido .= "<p>Presiona Aqui: <a href=\"" . $_ENV["PROJECT_URL"] . "/confirmar-cuenta?token=". $this->token ."\">Confirmar Cuenta</a>.</p>";
        $contenido .= "<p>Si tu no Solicitaste esta Cuenta, Puedes Ignorar este Mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        $mail->send();

    }

    public function enviarInstrucciones(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV["EMAIL_HOST"];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV["EMAIL_PORT"];
        $mail->Username = $_ENV["EMAIL_USER"];
        $mail->Password = $_ENV["EMAIL_PASS"];

        $mail->setFrom("cuenta@appsalon.com");
        $mail->addAddress("cuenta@appsalon.com", "APPSalon.com");
        $mail->Subject = "Reestablece tu Contraseña de APPSalon.com";

        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre . "</strong> Has Solicitado Reestablecer tu Contraseña, Sigue el Siguiente Enlace Para Hacerlo:</p>";
        $contenido .= "<p>Presiona Aqui: <a href=\"" . $_ENV["PROJECT_URL"] . "/recuperar?token=". $this->token ."\">Reestablecer Contraseña</a>.</p>";
        $contenido .= "<p>Si tu no Solicitaste este Cambio a tu Cuenta, Puedes Ignorar este Mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        $mail->send();
    }
}