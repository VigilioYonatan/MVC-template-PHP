<?php

namespace Controller;

use App\Request;
use App\Response;
use App\Router;

class UsuarioController
{

    public static function addUser()
    {
        if (request() === 'GET') {
            statusCode(400);
            echo json_encode("hola");
        }
    }
    public static function home(Router $router)
    {

        $router->render("webLayout", "web/home", [
            "title" => 'inicioPage',
            "var" => "hola mundo"
        ]);
    }
}