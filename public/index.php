<?php

require_once __DIR__ . '/../config/app.php';

use Controller\UsuarioController;
use MC\Router;


$router = new Router;

$router->post('/api/addUser', [UsuarioController::class, 'addUser']);
$router->get('/', [UsuarioController::class, 'home']);

$router->comprobarRutas();