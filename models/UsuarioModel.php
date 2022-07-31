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
     
    }
}