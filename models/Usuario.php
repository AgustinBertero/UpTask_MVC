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
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;

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

    //Hashea el password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //Generar un Token 
    public function crearToken(){
        $this->token = uniqid(); //uniqid genera un token, no usar para hashear password
    }

}


?>