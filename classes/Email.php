<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{

    public $email, $nombre, $token;
    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        //crear el objeto email
            $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail = $this->configInicial($mail);
            $mail->Subject = 'Correo de confirmación';
            $mail->Body    = '<html><p>Bien venido! este es el correo de confirmación para su cuenta</p>';
            $mail->Body    .= "<p>Para confirmar su cuenta debe hacer click <a href='http://".$_SERVER['SERVER_NAME']."/confirmarcuenta?token={$this->token}'><b>aquí</b></a> <p><html>";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function recuperarPassword(){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail = $this->configInicial($mail);
            $mail->Subject = 'Recuperar contraseña';
            $mail->Body    = '<html><p>Este es el correo para renovar su contraseña</p>';
            $mail->Body    .= "<p>Para renovar su contraseña debe hacer click <a href='http://localhost:3000/recuperarpassword?token={$this->token}'><b>aquí</b></a> <p><html>";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    private function configInicial($mail){
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '803b30f2c52c84';
            $mail->Password = 'c6e8d4cd4480c9';                              //SMTP password
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress($this->email, $this->nombre);
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->CharSet = 'UTF-8';
            return $mail;
    }
}
