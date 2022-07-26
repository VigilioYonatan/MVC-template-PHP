<?php

namespace Model;

use Model\ActiveRecord;

class UsuarioModel extends ActiveRecord
{
    protected static $tabla = 'usuario';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'rol_id'];

    public function __construct($args = [])
    {
        $this->id       = $args['id'] ?? null;
        $this->nombre   = $args['nombre'] ?? null;
        $this->email    = $args['email'] ?? null;
        $this->password = $args['password'] ?? null;
        $this->rol_id   = $args['rol_id'] ?? 1;
    }

    public function addUserValidate()
    {
        $validacion = new Middlewares;
        $validacion->validarRequired($this->nombre, 'Nombre');
        $validacion->validarRequired($this->email, 'Email');
        $validacion->validarRequired($this->password, 'Contrasena');
        $validacion->validarOnlyText($this->nombre, "Este campo solo permite letras: $this->nombre");
        $validacion->validarMaxLength($this->nombre, 30);
        $validacion->validarMinLength($this->nombre, 3);
        $validacion->validarEmail($this->email);
        $validacion->validarMinLength($this->password, 5);
    }
}