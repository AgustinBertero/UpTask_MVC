<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;

    }

    public function enviarConfirmacion() {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '269c9999938045';
        $mail->Password = 'b947c8123bedb3';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'uptask.com');
        $mail->Subject = 'Confirm your account';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>'; 
        $contenido .= "<p><strong>Hello " . $this->nombre . "</strong> You have created your account in Uptask, you only have to confirm it in the following link  </p>";
        $contenido .= "<p> Click here: <a href='http://localhost:3000/confirmar?token=" . $this->token . "'>Confirm Account</a> </p>";
        $contenido .= "<p> If you didn't create this account, you can ignore this message </p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        //Enviar el mail 
        $mail->send();
    }
}

?>