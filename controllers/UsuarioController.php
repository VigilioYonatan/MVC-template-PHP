<?php

namespace Controller;

use MVC\Router;
use Model\UsuarioModel;

class UsuarioController
{
    public static function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newUser = new UsuarioModel($_POST);
            $newUser->addUserValidate();
            $newUser->guardar();
            echo json_encode($newUser);
        }
    }
    public static function home(Router $router)
    {
        $router->render("web/home", [
            "title" => "hola mundo"
        ]);
    }
}