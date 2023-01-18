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
        $mail->Host = 'smtp-relay.sendinblue.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'agustinbertero.dev@gmail.com';
        $mail->Password = 'g4kKhJcIsUFmC3pT';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress($this->email);
        $mail->Subject = 'Confirm your account';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>'; 
        $contenido .= "<p><strong>Hello " . $this->nombre . "</strong> You have created your account in Uptask, you only have to confirm it in the following link  </p>";
        $contenido .= "<p> Click here: <a href='http://uptask.alwaysdata.net/confirmar?token=" . $this->token . "'>Confirm Account</a> </p>";
        $contenido .= "<p> If you didn't create this account, you can ignore this message </p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        //Enviar el mail 
        $mail->send();
    }

    public function enviarInstrucciones() {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.sendinblue.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'agustinbertero.dev@gmail.com';
        $mail->Password = 'xsmtpsib-181b6adc53a640b226417b4318fef57fb395055e53083a53656113cd2fe8ea66-O5f6j02A9TvzVG7p';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress($this->email);
        $mail->Subject = 'Reset your password';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>'; 
        $contenido .= "<p><strong>Hello " . $this->nombre . "</strong> You have forgotten your password, follow this link to retrieve it  </p>";
        $contenido .= "<p> Click here: <a href='http://uptask.alwaysdata.net/reestablecer?token=" . $this->token . "'>Reset password</a> </p>";
        $contenido .= "<p> If you didn't create this account, you can ignore this message </p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        //Enviar el mail 
        $mail->send();
    }

}

?>