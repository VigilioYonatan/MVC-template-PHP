<?php

namespace Controller;

use App\Router;
use Model\UsuarioModel;

class UsuarioController
{


    public static function addUser()
    {
        if (request() === 'GET') {
            $id = $_GET['id'] ?? 1;
            $productos = [
                ["id" => 1, "title" => "monstercat1", "precio" => 200, "cantidad" => 5],
                ["id" => 2, "title" => "monstercat2", "precio" => 400, "cantidad" => 6],
                ["id" => 3, "title" => "monstercat 3", "precio" => 600, "cantidad" => 3],
                ["id" => 4, "title" => "monstercat4", "precio" => 200, "cantidad" => 335],
                ["id" => 5, "title" => "monstercat5", "precio" => 400, "cantidad" => 23],
                ["id" => 6, "title" => "monstercat 6", "precio" => 600, "cantidad" => 323],
            ];

            $converted = array_filter($productos, fn ($producto) => $producto["id"] ===  intval($id));
            echo json_encode(["success" => true, "producto" => array_pop($converted)]);
        }
    }
    public static function home(Router $router)
    {
        $productos = [
            ["id" => 1, "title" => "monstercat1", "precio" => 200, "cantidad" => 5],
            ["id" => 2, "title" => "monstercat2", "precio" => 400, "cantidad" => 6],
            ["id" => 3, "title" => "monstercat 3", "precio" => 600, "cantidad" => 3],
            ["id" => 4, "title" => "monstercat4", "precio" => 200, "cantidad" => 335],
            ["id" => 5, "title" => "monstercat5", "precio" => 400, "cantidad" => 23],
            ["id" => 6, "title" => "monstercat 6", "precio" => 600, "cantidad" => 323],
        ];
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

        $router->render("web/home", [
            "title" => 'inicioPage',
            "user" => $newUser ?? null,
            "users" => $users,
            "productos" => $productos
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


        $router->render("web/editar", [
            "title" => 'Editar Page',
            "user" => $user

        ]);
    }

    public static function onRegister()
    {
        $usuario = new UsuarioModel($_POST);
        echo json_encode($usuario);
    }
}