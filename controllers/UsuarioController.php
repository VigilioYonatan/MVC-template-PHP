<?php

namespace Controller;

use App\Router;
use Model\UsuarioModel;

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
        if (isset($_GET['eliminar'])) {
            $eliminar = new UsuarioModel();
            $eliminar->id = cleanHtml($_GET['eliminar']);
            $eliminado = $eliminar->eliminar();
            if ($eliminado) {
                echo 'Eliminado';
            } else {
                header('Location: /');
            }
        }


        if (request() === 'POST') {
            $newUser = new UsuarioModel($_POST);
            $newUser->validacionAddUser();
            if ($newUser->validate()) {
                $resultado = $newUser->guardar();
                debuguear($resultado);
            }
        }
        $users = UsuarioModel::all();

        $router->render("webLayout", "web/home", [
            "title" => 'inicioPage',
            "user" => $newUser ?? null,
            "users" => $users
        ]);
    }
    public static function editar(Router $router)
    {
        $id = $_GET['id'];
        $user = UsuarioModel::find($id);

        if (request() === 'POST') {

            debuguear($_POST);
            $args = $_POST['usuario'];
            $user->sincronizar($args);

            $user->sanitizarAtributos();
            $user->validacionEditUser();
            debuguear($user);

            if ($user->validate()) {
                $resultado = $user->guardar();
                if ($resultado) {
                    header('Location: /');
                }
            }
        }


        $router->render("webLayout", "web/editar", [
            "title" => 'Editar Page',
            "user" => $user

        ]);
    }
}