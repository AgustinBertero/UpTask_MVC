<?php 
namespace Model;


class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;

    }

    //  Validar el Login de Usuario

    public function validarLogin() {
        if (!$this->email) {
            self::$alertas['error'][] = 'Customer email is required';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Invalid Email';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'Password cannot be empty';
        }
        return self::$alertas;
    
    }



    //Validacion para cuentas nuevas
    public function validarNuevaCuenta() {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'Customer name is required';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'Customer email is required';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'Password cannot be empty';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'Password must contain at least 6 characters';
        }
        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Passwords must be the same ';
        }

        return self::$alertas;
    }

    //Valida el Email

    public function validarEmail(){
        if (!$this->email) {
            self::$alertas['error'][] = 'The email address is required';
        } 

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Invalid Email';
        }
        return self::$alertas;
    }

    //Valida el password a reestablecer 

    public function validarPassword() {
        if (!$this->password) {
            self::$alertas['error'][] = 'Password cannot be empty';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'Password must contain at least 6 characters';
        }

        return self::$alertas;
    }

    public function validar_perfil(){
        if (!$this->nombre) {
            self::$alertas['error'][] = 'The name is required';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'The email is required';
        }
        return self::$alertas;
    }

    //Valido el cambio de password
    public function nuevo_password() : array{
        if(!$this->password_actual) {
            self::$alertas['error'][] = 'The current password cannot be empty';
        }
        if(!$this->password_nuevo) {
            self::$alertas['error'][] = 'The new password cannot be empty';
        }
        if(strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'The password must contain at least 6 characters';
        }
        return self::$alertas;
    }

    //Comprobar el password 
    public function comprobar_password() : bool { //Usamos el tipado de PHP: debe retornar un bool
        return password_verify($this->password_actual, $this->password);
    }


    //Hashea el password
    public function hashPassword() : void { //Void: no retorna nada
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //Generar un Token 
    public function crearToken(): void {
        $this->token = uniqid(); //uniqid genera un token, no usar para hashear password
    }

}


?>