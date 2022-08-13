<?php

require_once __DIR__ . '/../app/app.php';

use App\Router;
use Controller\UsuarioController;


$router = new Router();
$router->get('/api/user', [UsuarioController::class, 'addUser']);
$router->get('/', [UsuarioController::class, 'home']);
$router->post('/', [UsuarioController::class, 'home']);
$router->get('/editar', [UsuarioController::class, 'editar']);
$router->post('/editar', [UsuarioController::class, 'editar']);

$router->comprobarRutas();