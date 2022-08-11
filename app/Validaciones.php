<?php

namespace App;

// *example to api
// $newUser = new UsuarioModel($_POST);
// // validaciones 
// $newUser->registerValidate();
// $newUser->validate();
// $newUser->getErrorAPI();

abstract class Validaciones
{

    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    protected $rules;

    protected function rules(array $rules)
    {
        $this->rules = $rules;
    }

    public function validate()
    {
        foreach ($this->rules as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as  $rule) {
                $ruleName = $rule;


                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorByRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorByRule($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorByRule($attribute, self::RULE_MIN, ['min' => $rule['min']]);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorByRule($attribute, self::RULE_MAX, ['max' => $rule['max']]);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorByRule($attribute, self::RULE_MATCH, ['match' => $rule['match']]);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr  = $rule['attribute'] ?? $attribute;
                    $instance = ActiveRecord::$tabla = $className;
                    $statement = $instance::where($uniqueAttr, $value);
                    if ($statement) {
                        $this->addErrorByRule($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                    }
                }
            }
        }

        return empty($this->errors);
    }


    public function addErrorByRule(string $attribute, string $rule, $params = [])
    {
        $message =  $this->errorMessages()[$rule] ?? '';

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'Este campo es obligatorio',
            self::RULE_EMAIL => 'Este campo debe ser un email válido',
            self::RULE_MIN => 'Campo debe ser minimo de {min}',
            self::RULE_MAX => 'Campo debe ser maximo {max}',
            self::RULE_MATCH => 'Este campo DEBE SER el mismo como {match}',
            self::RULE_UNIQUE => 'Este {field} ya existe en nuestro sistema'
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }
    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }
    public function getFirstError($attribute)
    {
        $errors = $this->errors[$attribute] ?? [];
        return $errors[0] ?? '';
    }
    public function getErrorAPI()
    {
        if (!empty($this->errors)) {
            foreach ($this->errors as $key => $value) {
                statusCode(400);
                echo json_encode([$key => $value[0]]);
                die;
            }
        }
    }
}