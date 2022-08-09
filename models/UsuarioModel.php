<?php

namespace Model;

use App\ActiveRecord;

class UsuarioModel extends ActiveRecord
{
    protected static $tabla = 'users';
    protected static $columnasDB = ['id', 'email', 'firstname', 'lastname', 'status', 'created_at', 'password', 'confirmPassword'];

    public function __construct($args = [])
    {
        $this->id       = $args['id'] ?? null;
        $this->email   = $args['email'] ?? '';
        $this->firstname    = $args['firstname'] ?? '';
        $this->lastname = $args['lastname'] ?? '';
        $this->status  = $args['status'] ?? 1;
        $this->created_at  = $args['created_at'] ?? '';
        $this->password  = $args['password'] ?? '';
        $this->confirmPassword  = $args['confirmPassword'] ?? '';
    }

    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
        ];
    }
}