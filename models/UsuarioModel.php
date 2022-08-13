<?php

namespace Model;

use App\ActiveRecord;

class UsuarioModel extends ActiveRecord
{
    protected static $tabla = 'usuario';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password'];

    public function __construct($args = [])
    {
        $this->id       = $args['id'] ?? null;
        $this->nombre   = $args['nombre'] ?? '';
        $this->email   = $args['email'] ?? '';
        $this->password   = $args['password'] ?? '';
    }

    public function validacionAddUser(): void
    {
        $validacion = [
            "nombre" => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3], [self::RULE_MAX, 'max' => 24]],
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 5], [self::RULE_MAX, 'max' => 24]],
        ];

        $this->rules($validacion);
    }
    public function validacionEditUser(): void
    {
        $validacion = [
            "nombre" => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3], [self::RULE_MAX, 'max' => 24]],
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 5], [self::RULE_MAX, 'max' => 24]],
        ];

        $this->rules($validacion);
    }
}